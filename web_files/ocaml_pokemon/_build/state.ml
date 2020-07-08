open Pokemon
open Gameworld

(** A [PokemonRoster] maps pokemon names to [pokemon]. *)
module PokemonRoster = Map.Make (struct
    type t = string
    let compare = Stdlib.compare
  end
  )

open PokemonRoster

(**[make_roster pknd curr p] is a [PokemonRoster] with [pknd] elements where
   [curr] is an accumulator for the roster. [p] is a set of valid pokemon used 
   to populate the [PokemonRoster]. *)
let rec make_roster poke_needed curr_roster pokedex=
  if cardinal curr_roster <> poke_needed then
    let v = random_pokemon pokedex in
    let k = get_name v in
    make_roster poke_needed (add k v curr_roster) pokedex
  else curr_roster

(**[create_roster fst g p] is a [PokemonRoster] whose length is specified in
   game [g] and which contains the pokemon [fst]. [p] is a set of valid pokemon 
   used to populate the [PokemonRoster] . *)
let create_roster fst_poke game pokedex =
  let roster_length = roster_length game in
  let initial_ros = (add (get_name fst_poke) fst_poke PokemonRoster.empty) in
  make_roster roster_length initial_ros pokedex

type t = {
  roster: pokemon PokemonRoster.t;
  my_pokemon : string;
  current_room: room;
  defeated_characters: string list;
  visited_rooms : room list;
  player_name : string;
}

let init_state (game) pokedex (poke: string) (player: string)=
  let fst_poke = get_pokemon pokedex poke in
  {
    roster = (create_roster fst_poke game pokedex);
    my_pokemon = get_name fst_poke; 
    current_room = Gameworld.start_room game |> 
                   Gameworld.room_name |> get_room game; 
    defeated_characters = []; 
    visited_rooms = [start_room game |> room_name |> get_room game;];
    player_name = player
  }

let player_name st =
  st.player_name

let current_room st =
  st.current_room

let curr_pokemon st =
  find st.my_pokemon st.roster

(** [visited_room st] is the visited rooms in the state [st] *)
let visited_rooms st =
  st.visited_rooms

type result = Legal of t | Illegal

let chars_left game st= 
  char_diff game st.defeated_characters

(**[chars_remaining g st] is a list of tuples of non-elite character 
   which still have to be defeated in state [st] and the rooms their in, in
    game [g]*)
let chars_remaining game st=
  let chars_rem =  chars_left game st in
  let add_room g c = (get_char_room c g, c) in
  List.map (add_room game) chars_rem

let stringify_opps game st =
  let chr_list = chars_remaining game st in 
  let str_chr c ((a, b):(string * string))= b^" is in "^a^"\n"^c in
  List.fold_left str_chr "" chr_list 

let opps_left game st=
  let rm_chars =  get_room_chars st.current_room in
  let char_beaten a = not (List.mem a st.defeated_characters) in
  List.filter char_beaten rm_chars 

let go s game st =
  let elite_char chrs = 
    List.fold_right (||) (List.map (in_elite3 game) chrs) false in
  let rm_visit = room_to_visit game st.current_room s  in
  let nxt_rm_chars =  get_room_chars rm_visit in
  let elite_next = elite_char nxt_rm_chars in
  if elite_next then begin
    if (chars_left game st) = [] then begin
      Legal {st with current_room = rm_visit ;
                     visited_rooms = rm_visit::st.visited_rooms}
    end else begin
      Illegal
    end
  end  else
    Legal {st with current_room = rm_visit ;
                   visited_rooms = rm_visit::st.visited_rooms}

let defeated_char  char_name st=
  if List.mem char_name st.defeated_characters then st else begin
    {st with defeated_characters = char_name::st.defeated_characters}
  end

let game_over game st =
  let elite = elite3 game in
  let elite_scan a= List.mem a st.defeated_characters in
  let elite_bool = List.map elite_scan elite in
  List.fold_left (&&) true elite_bool

let update_pokemon st pk1 =
  let new_roster = add st.my_pokemon pk1 st.roster in 
  {st with roster = new_roster}

(** [string_roster a] is a human-readble string which contains the 
    hp and xp of all pokemons in the list [a] *)
let string_roster assosc =
  let string_ros (a, b) c = 
    c^" "^ a^" of level "^ string_of_int (get_level b) ^
    " has health: "^(string_of_int (get_hp b))^" and xp "
    ^(string_of_int (get_xp b))^"\n" in
  List.fold_right string_ros assosc ""

let stats_string st =
  let assosc =  bindings st.roster in
  string_roster assosc

(** [alive_pokemon st] is a assosciation list of the pokemon alive in 
    state [st] *)
let alive_pokemon st =
  let assosc = bindings st.roster in
  let is_alive (a, b) = (get_hp b) > 0 in
  List.filter is_alive assosc

let alive_string st =
  string_roster (alive_pokemon st)

let in_alive st s=
  let extract_name (a,b) = a in
  let alive_strings = List.map extract_name (alive_pokemon st) in
  List.mem s alive_strings

let switch_poke st s =
  {st with my_pokemon = s}

let pokemon_left st =
  not ((alive_pokemon st)=[])

let rec lvlpkmn int (pkmn:pokemon) = 
  match int with
  |0 -> pkmn 
  |_ -> lvlpkmn (int-1) (level_up pkmn)

let wild_pokemon currlvl pokedex : pokemon option=
  let _ =  Random.self_init () in 
  let chance = Random.int 10 in
  let wildpkmn = random_pokemon pokedex in
  let lvldwild = lvlpkmn currlvl wildpkmn in
  if chance > 0 then Some lvldwild else None

let try_to_heal p st =
  if PokemonRoster.mem (get_name p) st.roster 
  then Some (PokemonRoster.find (get_name p) st.roster |> Pokemon.heal_pokemon)
  else None

let update_roster p st =
  {st with roster = PokemonRoster.add (get_name p) p st.roster}