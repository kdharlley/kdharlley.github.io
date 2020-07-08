open Pokemon
open Yojson.Basic.Util
exception UnknownMovement of string
(** Raised when an unbeaten character prevents the game from progressing.*)
exception UnBeatenCh of string
exception DeadEnd

type character = {
  name: string;
  description: string;
  pokemon: pokemon;
}

(** [character_from_json pokedex json] is the [character] represented by [json].
    [pokedex] is used to obtain the chearacter's pokemon *)
let character_from_json pokedex json= {
  name = json |> member "name" |> to_string;
  description = json |> member "description" |> to_string ;
  pokemon = json |> member "pokemon" |> to_string |> 
            Pokemon.get_pokemon pokedex;
}

type room = {
  north_room: string;
  south_room: string;
  east_room: string;
  west_room: string;
  description: string;
  name: string;
  characters: character list;
  has_pokemon_center : bool;
}

(** [room_from_json pokedex json] is the [room] represented by [json].
    [pokedex] is used to obtain in-room characters' pokemon *)
let room_from_json pokedex json= {
  north_room = json |> member "north_room" |> to_string;
  south_room = json |> member "south_room" |> to_string;
  east_room = json |> member "east_room" |> to_string;
  west_room = json |> member "west_room" |> to_string;
  description = json |> member "description" |> to_string;
  name = json |> member "name" |> to_string;
  characters = json |> member "characters" |> to_list |> 
               List.map (character_from_json pokedex);
  has_pokemon_center= json |> member "has_pokemon_center" |> to_bool;
}

type game = {
  rooms: room list;
  description: string;
  start_room: string;
  elite3: string list;
  roster_length: int
}

let game_json json pokedex = {
  rooms = json |> member "rooms" |> to_list |> 
          List.map (room_from_json pokedex);
  description = json |> member "description" |> to_string;
  start_room = json |> member "start_room" |> to_string;
  elite3 = json |> member "elite3" |> to_list |> List.map to_string;
  roster_length = json |> member "roster_length" |> to_int ;
}

(** [get_rooms_ext s rms] is the room with name [s] in the list of rooms
    [rms] 
    Raises: [Failure] with an unspecified error message if [s] is not a valid 
    room name. *)
let rec get_rooms_ext s rms =
  match rms with
  | [] -> failwith "no rooms"
  | h::t -> if h.name = s then h else get_rooms_ext s t

let  get_room game s =
  if s = "" then begin
    raise DeadEnd
  end else get_rooms_ext s game.rooms

(** [get_chars_ext s chrs] is None if [s] is not in chrs, else it is [Some chr] 
    where chr is the character with name [s]. *)
let rec get_chars_ext s (chars:character list) = 
  match chars with
  | [] -> None
  | h::t -> if s=h.name then Some h else get_chars_ext s t

let get_char rm s=
  match get_chars_ext s rm.characters with
  | Some h -> h
  | None -> failwith "No such room"

let valid_char rm s =
  match get_chars_ext s rm.characters with
  | Some h -> true
  | None -> false

let get_room_chars rm = 
  let extract_name (x:character) = x.name in
  List.map extract_name rm.characters

(** [start_room game] returns the start room of game [game] *)
let start_room game =
  let start_name = game.start_room in
  get_room game start_name 

let char_pokemon ch =
  ch.pokemon

let pokemon_center rm =
  rm.has_pokemon_center

(** [north_room g r] is the room to the north of room [r] in game g*)
let north_room game rm =
  get_room game rm.north_room

(** [south_room g r] is the room to the south of room [r] in game g*)
let south_room game rm =
  get_room game rm.south_room

(** [east_room g r] is the room to the east of room [r] in game g*)
let east_room game rm =
  get_room game rm.east_room

(** [west_room g r] is the room to the west of room [r] in game g*)
let west_room game rm=
  get_room game rm.west_room

let room_desc game s =
  let rm = get_room game s  in 
  rm.description

let room_name room =
  room.name

let room_to_visit game curr s = 
  if s = "north" then (north_room game curr)
  else if s = "south" then (south_room game curr)
  else if s = "east" then (east_room game curr)
  else if s = "west" then (west_room game curr)
  else raise (UnknownMovement s)

let elite3 game  =
  game.elite3

let list_chars game =
  let extract_name (y:character) = y.name in
  let merge_chars x y = (List.map extract_name x.characters)@y in
  List.fold_right merge_chars game.rooms []

let non_elites game =
  let char_list = list_chars game in
  let elites = game.elite3 in
  let elite_checker a = not (List.mem a elites) in
  List.filter elite_checker char_list

let char_diff game def_chars =
  let basics = non_elites game in
  let char_diff a = not (List.mem a def_chars) in
  List.filter char_diff basics

let get_char_room char game=
  let char_in name room = valid_char room name in 
  let room_list = List.filter (char_in char) game.rooms in
  match room_list with
  | [] -> failwith "Player should be in a room"
  | h::t -> h.name

let in_elite3 game ch =
  List.mem ch game.elite3

let roster_length game =
  game.roster_length