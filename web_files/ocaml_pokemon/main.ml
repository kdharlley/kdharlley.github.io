
open Pokemon
open Attacks
open Gameworld
open State
open Command

(** [rules_msg] is a string representing the rules of the game. *)
let rules_msg =
  " Your goal is to defeat the elite trainers, \
   in order to battle them, you must first defeat \
   all of the regular trainers. \n
  To navigate around the map, use the command 'go' followed by any cardinal \
   direction. \n 
  To end the game, use the command 'quit' \n 
  To check the status of your pokemon at any time, use the command 'stats' \n
  To find a non-elite trainer, use 'opps' to see where they are, and \
   the command 'observe' to check the trainers in your current \
   room \n
  To battle, enter 'challenge' followed by the name of the trainer \
   you would like to battle.\n 
  You will then be prompted to either battle, switch your pokemon, or run. \n  
  After a battle, your pokemon may need to be healed. To do this, you must go \
   to a room that has a pokemon center.  Once you \
   are there, use the command 'heal' followed by \
   the pokemon's name. \n
  \n One last thing! There are a lot of wild pokemon in this world! If you \
   want \
   to train your pokemon to make them stronger, \
   simply use the command 'search' to search your \
   area for wild pokemon to battle! \n \n
   Have fun! \n"

(** [extract_state curr_st new_st] is the state represented by the 
    result [new_st], with [curr_st] being the previous state.
    If [new_st] is [Illegal] [curr_st] is returned *)
let extract_state curr_st new_st = 
  match new_st with
  | Legal st -> st
  | Illegal -> curr_st

(** [scale_lvl st] is a pseudo-random integer scaled to be relatively and 
    randomly less than the current pokemon's level in [st]. *)
let scale_lvl st =
  let _ =  Random.self_init () in 
  let rand_num = Random.int ((get_level (curr_pokemon st))-5) in
  max rand_num 0 

(** [prcs_lvl s] returns the input string [s] with the first letter of each
    word capitalized, the remaining letters lowercase, and only one space in
    between words*)
let prcs_sens s =
  let new_str = String.lowercase_ascii s |> String.split_on_char ' ' in
  let rm_space a = a <> "" in
  let fin_lst = List.filter rm_space new_str in
  let cap_lst = List.map String.capitalize_ascii fin_lst in
  String.concat " " cap_lst

(** [scale_lvl_trainer pkm st] is pokemon [pkm] levelled up a number of times.
    The number of times [pkm] is levelled up is based on the current pokemon's 
    level in [st]. *)
let scale_lvl_trainer pkmn st : pokemon =
  let scale = scale_lvl st in
  lvlpkmn scale pkmn

(** [input_player_name ()] reads and returns the user's inputted name.*)
let rec input_player_name () : string =
  print_endline "What is your name?\n";
  print_string "> ";
  read_line () 

(** [choose_character f pokedex] lets the player choose their character and 
    pokemon in the game represented by file [f] and creates an initial state 
    with that character. [pokedex] is a set of valid pokemon*)
let rec choose_character f pokedex : State.t=
  let player= input_player_name () in
  print_string (player ^ ", what type pokemon would you like?\n");
  print_string "> ";
  match  (pokemon_of_type (read_line ()) pokedex []) with 
  | exception exn -> 
    print_endline ("There appears to be a problem. Please start again."); 
    choose_character f pokedex
  | [] ->
    print_endline 
      ("Sorry, there are no pokemon of that type. Please start again."); 
    choose_character f pokedex
  | t -> 
    print_endline "Select your pokemon. Your options are: \n";
    print_endline (String.concat " || " t);
    print_string  "> ";
    let game = game_json (Yojson.Basic.from_file f) pokedex in
    select_pokemon f pokedex game t player


(** [select_pokemon f pokedex game t player] lets the player [player] pick a 
    pokemon from a list of pokemon [t] in the game [g] represented by file [f]
     and creates an initial state with that character. [pokedex] is a set of 
     valud pokemon.*)
and select_pokemon f pokedex game t player= 
  match get_pokemon pokedex (prcs_sens (read_line ())) with
  | p -> 
    let chosen_name = get_name p in
    if List.mem chosen_name t 
    then init_state game pokedex chosen_name player else begin
      print_endline "That isnt a valid option. Please start again."; 
      choose_character f pokedex
    end
  | exception exn-> 
    print_endline ("There appears to be a problem. Please start again.");
    choose_character f pokedex

(** [eval_loop game pkdex atdir st] prompts the user to enter a command, then
    parses that command, matching it with the correct command evaluation branch
    and continuing the game [game] whiles potentially updating values in [st], 
    or matches improper commands with descriptive error messages which then 
    prompt the user to enter a better command. [pkdex] is a set of valid
     pokemon and [atdir] is a set of valid attacks. *) 
let rec eval_loop game pkdex atdir st =
  (* Part of loop that handles out of battle logic *)
  if game_over game st then begin
    print_endline "Good Job Dude, you won"; Stdlib.exit 0
  end else ();
  let curr_room = current_room st in
  let curr_room_name = room_name curr_room in
  print_endline (room_desc game (curr_room_name));
  print_endline (get_description (curr_pokemon st));
  print_endline "Please enter your next move.\n";
  print_string  "> ";
  try match parse (read_line ()) with
    | Go s-> go_cmd game pkdex atdir st s 
    | Quit -> print_endline "Thanks for playing!!"; Stdlib.exit 0
    | Rules -> 
      print_endline rules_msg; eval_loop game pkdex atdir st
    | Challenge s ->
      let char_name = String.lowercase_ascii (String.concat " " s) |> 
                      String.capitalize_ascii in
      if valid_char curr_room char_name then begin
        let opp = get_char curr_room char_name in
        print_endline ("You have challenged "^char_name);
        battle_loop game pkdex atdir st (curr_pokemon st) 
          (scale_lvl_trainer (char_pokemon opp) st) true char_name
      end else print_endline "Please input a valid character name"; 
      eval_loop game pkdex atdir st
    | Observe ->   
      print_endline ("The following characters are in this room: "
                     ^(String.concat " " (get_room_chars curr_room))); 
      eval_loop game pkdex atdir st
    | PokemonStats ->print_endline (stats_string st); 
      eval_loop game pkdex atdir st
    | Switch -> begin
        let new_st = new_pokemon game st in eval_loop game pkdex atdir new_st
      end
    | Opps -> print_endline (stringify_opps game st); 
      eval_loop game pkdex atdir st
    | Battle | Run -> print_endline "This isn't a valid command here"; 
      eval_loop game pkdex atdir st
    | Heal p-> heal_cmd game pkdex atdir st p curr_room
    | Search -> match wild_pokemon (scale_lvl st) pkdex with 
      | Some pk2 -> print_endline ("Ah-hah! A wild pokemon was spotted!\n");
        battle_loop game pkdex atdir st 
          (curr_pokemon st) pk2 true "the Wild Pokemon"
      | None -> print_endline ("There are no wild pokemon in this area"); 
        eval_loop game pkdex atdir st;
  with
  | Malformed -> print_endline "That command was malformed! do better :)"; 
    eval_loop game pkdex atdir st
  | Empty -> print_endline "Empty Command"; eval_loop game pkdex atdir st
  | UnknownMovement s -> 
    print_endline  
      ("That is an invalid direction, please input a valid direction.");
    eval_loop game pkdex atdir st
  | DeadEnd  -> print_endline 
                  ("That is a dead end, please input a different direction."); 
    eval_loop game pkdex atdir st
  | exn -> print_endline "A weird problem was encountered in game, 
    please make sure you're following the rules of the game"; 
    eval_loop game pkdex atdir st

(** [go_cmd game pkdex atdir st s] updates the state [st] if moving in the 
    direction [s] in game [game] leads to a valid state. If not, appropiate 
    error messages are printed. [pkdex] is a set of valid pokemon
    and [atdir] is a set of valid attacks. *)
and go_cmd game pkdex atdir st s =
  let command_name = String.lowercase_ascii (String.concat " " s)  in
  let new_state = go command_name game st |> extract_state st in
  if new_state = st then begin
    let rm_opps = opps_left game st in
    let basics = chars_left game st in
    if basics <> [] then begin
      print_endline 
        "You must beat the following basic trainers before you can proceed to\
         the elite: " ;
      print_endline (stringify_opps game st);
      eval_loop game pkdex atdir new_state
    end else begin
      print_endline "You have to beat the following trainers in this room to \
                     proceed: " ;
      print_endline (String.concat " " rm_opps);
      eval_loop game pkdex atdir new_state
    end
  end else eval_loop game pkdex atdir new_state

(** [heal_cmd game pkdex atdir st p curr_room] if the [curr_room] has a pokemon 
    center,  the state [st] is updated with a healed pokemon [p]. Otherwise, 
    appropiate error messages are printed. [pkdex] is a set of valid pokemon
    and [atdir] is a set of valid attacks. *)
and heal_cmd game pkdex atdir st p curr_room=
  let poke_to_heal = prcs_sens (String.concat " " p) |> 
                     get_pokemon pkdex in
  if pokemon_center curr_room then 
    (match try_to_heal poke_to_heal st with
     | Some p -> print_string "Your pokemon was healed. \n"; 
       eval_loop game pkdex atdir (update_roster p st)
     | None -> eval_loop game pkdex atdir st
    )
  else print_endline ("There are no pokemon centers here."); 
  eval_loop game pkdex atdir st

(** [new_pokemon game st] prompts the user to select a new pokemon from their
    roster in game[game], updates the game state [st] with their selection, 
    and returns this new state. *)
and new_pokemon game st =
  print_endline "The current pokemon available in your roster are: \n";
  print_endline (alive_string st);
  print_endline "Please select your next pokemon: ";
  try match  (read_line ()) with
    | p -> let s = prcs_sens p in
      if in_alive st s then begin
        let new_st = switch_poke st s in
        print_endline ("You successfully switched pokemon to "^s);
        new_st
      end else begin
        print_endline "That was an invalid pokemon selection.
         Please try again";
        new_pokemon game st  
      end
  with
    exn -> begin
      print_endline "That was a invalid pkmn. Please input a valid pokemon";
      new_pokemon game st  
    end

(** [print_battle_effects pk1 new_pk2 pk1_name pk2_name attack_s] prints an
    organized battle summary for the user after [pk1] with name [pk1_name]
    attacks [new_pk2] with name [pk2_name] with [attack_s].  *)
and print_battle_effects pk1 new_pk2 pk1_name pk2_name attack_s=
  print_endline "====================================";
  print_endline "\tBATTLE SUMMARY\t";
  print_endline "====================================";
  print_endline (pk1_name^" attacked with "^attack_s);
  print_endline (pk2_name^" took damage and its hp is now: "^
                 (string_of_int (get_hp new_pk2)));
  print_endline "====================================";

  (** [ai_battle_action game pkdex atdir st ai_pk pk2 char_name] is a tuple
      containing whether the player's pokemon [pk2] is dead after being 
      attacked by [char_name]'s pokemon [ai_pk] in state [st], the new state
      after damage has been dealt to [pk2] and the new pokemon [pk2] after
       damage has been dealt to it. [pkdex] is a set of valid pokemon and
        [atdir] is a set of valid attacks in game [game].*)
and ai_battle_action game pkdex atdir st ai_pk pk2 char_name =
  let attack_s =  opp_move (get_attacks_list ai_pk)  in
  let attk = (get_atk attack_s atdir) in 
  let opp_name = get_name ai_pk in
  let pk2_name = get_name pk2 in
  let new_pk2 = pokemon_attack ai_pk pk2 attk in
  print_battle_effects ai_pk new_pk2 opp_name pk2_name attack_s;
  let pk2_dead = (is_dead new_pk2) in
  if pk2_dead then begin
    print_endline ("You lost the battle " ^(player_name st) ^ 
                   " and were defeated by "^char_name);
    (pk2_dead, (update_pokemon st new_pk2), new_pk2)
  end else  (pk2_dead, (update_pokemon st new_pk2), new_pk2)

(** [battle_action game pkdex atdir st pk1 pk2 atk_s char_name] is a tuple
    containing whether [char_name]'s pokemon [pk2] is dead after being attacked 
    by [pk1] in state [st] with attack [atk_s], the new state after 
    damage has been dealt to [pk2] and the new pokemon [pk2] after damage has 
    been dealt to it. [pkdex] is a set of valid pokemon and [atdir] is a set of
     valid attacks in game [game].*)
and battle_action game pkdex atdir st pk1 pk2 atk_s char_name=
  let attk = (get_atk atk_s atdir) in
  let pk1_name = get_name pk1 in
  let pk2_name = get_name pk2 in
  let new_pk2 = pokemon_attack pk1 pk2 attk  in
  print_battle_effects pk1 new_pk2 pk1_name pk2_name atk_s;
  let pk2_dead = (is_dead new_pk2) in
  if pk2_dead then begin
    let mypkmn = update_lvl pk1 new_pk2 in
    print_endline (pk2_name^" is dead! "^ (player_name st)^ ", "^pk1_name^
                   " was victorious");
    print_endline ("You won the battle " ^(player_name st) ^ 
                   " and defeated "^char_name);
    (pk2_dead ,(defeated_char char_name (update_pokemon st mypkmn)), new_pk2)
  end else (pk2_dead, (update_pokemon st pk1), new_pk2)

(** [battle_processing game pkdex atdir st pk1 pk2 battle_start char_name atks]
    allows a user to pick one of the player's current pokemon [pk1] moves 
    [atks] in state [st]. If the move is valid, [pk1] attacks [char_name]'s 
    [pk2] with it after which [pk2] attacks [pk1] with one of its own attacks
    , else an error message is printed. [battle_start] contains whether this
     is the first battle phase, [pkdex] is a set of valid pokemon and [atdir] 
     is a set of valid attacks in game [game]. *)
and battle_processing game pkdex atdir st pk1 pk2 battle_start char_name atks=
  match (read_line ()) with 
  | m -> let move = prcs_sens m in
    if (valid_move atks move) then begin
      let new_st_opt = 
        battle_action game pkdex atdir st pk1 pk2 move char_name in
      ai_battle game pkdex atdir st pk1 pk2 battle_start char_name atks 
        new_st_opt
    end
    else print_endline "This isn't a valid move"; 
    battle_loop game pkdex atdir st pk1 pk2 battle_start char_name
  | exception End_of_file -> print_endline "That is an illegal command"; 
    battle_loop game pkdex atdir st pk1 pk2 battle_start char_name

(** [ai_battle game pkdex atdir st pk1 pk2 battle_start char_name atks] 
    processes  [char_name]'s pokemon [pk2] battling [pk1] with
    [new_st_opt] containing modified state data from [pk1] battling [pk2].  
    [st] is the previous state, [battle_start] contains whether this
     is the first battle phase, [pkdex] is a set of valid pokemon and [atdir] 
     is a set of valid attacks in game [game]. *)
and ai_battle game pkdex atdir st pk1 pk2 battle_start char_name atks 
    new_st_opt =
  match new_st_opt with
  | (true, new_st, opp_pk) -> eval_loop game pkdex atdir new_st 
  | (false, new_st, opp_pk) ->  begin
      let pk1_new = curr_pokemon new_st in
      let new_state_ai = 
        ai_battle_action game pkdex atdir new_st opp_pk pk1_new char_name in
      match new_state_ai with
      | (true, new_st, pk1)-> begin
          if pokemon_left new_st then begin
            let new_st_ai = new_pokemon game new_st in
            let new_pk1 = curr_pokemon new_st_ai in
            battle_loop game pkdex atdir new_st_ai 
              new_pk1 opp_pk battle_start char_name
          end else begin
            print_endline "Dude all your guys died";
            print_endline "The game is over and you lost :(";
            Stdlib.exit 0 
          end
        end
      | (false, new_st, pk1) -> 
        battle_loop game pkdex atdir new_st (curr_pokemon new_st) opp_pk false 
          char_name
    end

(** [battle_loop game pkdex atdir st pk1 pk2 battle_start char_name] prompts 
    the user to enter a command, then parses that command, matching it with the 
    correct command evaluation branch and continuing the [game] whiles 
    potentially updating values in [st], [pk1] and [pk2] , or matches improper 
    commands with descriptive error messages which then prompt the user to 
    enter a better command.  [battle_start] contains whether this is the first 
    battle phase, [char_name] is the ai opponent, [pkdex] is a set of valid
     pokemon and [atdir] is a set of valid attacks. *)
and  battle_loop game pkdex atdir st pk1 pk2 battle_start char_name= 
  if battle_start then begin 
    print_endline ("Your Pokemon "^(get_name pk1)^ " of level "
                   ^(string_of_int (get_level pk1))
                   ^" has entered the battle field");
    print_endline ("The opponent's Pokemon "^(get_name pk2)^" of level "
                   ^(string_of_int (get_level pk2))
                   ^" has entered the battle field");
  end else ();
  print_endline ("Do you want to Battle, Switch Pokemon or Run");
  try match parse (read_line ()) with
    | Run ->print_endline "You fled."; 
      eval_loop game pkdex atdir (update_pokemon st pk1)
    | Quit -> print_endline "Thanks for playing!!"; Stdlib.exit 0 
    | Battle -> begin
        let atks = get_attacks_list pk1 in
        print_endline ("Your moves are: "^(String.concat " || " atks));
        print_endline "Which would like to use?";
        battle_processing game pkdex atdir st pk1 pk2 battle_start char_name
          atks
      end
    | PokemonStats ->print_endline (stats_string st); 
      battle_loop game pkdex atdir st pk1 pk2 battle_start char_name
    | Go s | Challenge s | Heal s -> 
      failwith "This command shouldn't work here"
    | Observe | Opps  |Search | Rules ->
      failwith "This command shouldn't work here"; 
    | Switch -> begin
        let new_st = new_pokemon game st in
        battle_loop game pkdex atdir new_st (curr_pokemon new_st) 
          pk2 battle_start char_name
      end 
  with
  | Malformed -> print_endline "Invalid Command"; 
    battle_loop game pkdex atdir st pk1 pk2 battle_start char_name
  | Empty -> print_endline "Empty Command"; 
    battle_loop game pkdex atdir st pk1 pk2 battle_start char_name
  | Failure s -> print_endline "This command is invalid in a battle."; 
    battle_loop game pkdex atdir st pk1 pk2 battle_start char_name
  | exn -> print_endline "That is an invalid command";
    battle_loop game pkdex atdir st pk1 pk2 battle_start char_name


(** [play_game f] starts the game in file [f].
    Prints an error message if [f] is an invalid file and then prompts for a
    valid file to start*)
let rec play_game f=
  try
    let pokedex =  from_json (Yojson.Basic.from_file "pokemon.json") in
    let game =  game_json (Yojson.Basic.from_file f) pokedex in
    let attack_dir =  attack_dict (Yojson.Basic.from_file "attacks.json") in
    let st = choose_character f pokedex in
    eval_loop game pokedex attack_dir st
  with exn -> 
    print_endline "Invalid filename, please enter a valid file";
    print_endline "Please enter the name of the pokemon game you want to
     load.\n";
    print_string  "> ";
    match read_line () with
    | exception End_of_file -> ()
    | file_name ->  play_game file_name

(** [characters] creates an empty string list of characters *)
let characters:(string list)= [] 

(** [main ()] starts the game and prompts the user to enter a game file to 
    load*)
let main () =
  ANSITerminal.(
    print_string [red] "\n\nWelcome to the 3110 Pokemon Battle Game engine.\n
                  \nUse command 'rules' for a overview of how to play!\n");
  print_endline "Please enter the name of the game file you want to load.\n";
  print_string  "> ";
  match read_line () with
  | exception End_of_file -> ()
  | file_name -> play_game file_name 

let ()= main ()
