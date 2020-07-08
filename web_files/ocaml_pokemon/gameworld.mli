(**  Representation of static game data. 

     This module represents the data stored in game files,
     including the room names and description. It handles loading of that 
     data from JSON as well as querying the data. 
*)

open Pokemon

(** The abstract type of values representing a charcter in the game *)
type character

(** The abstract type of values representing a room in the game *)
type room

(** The abstract type of values representing a game *)
type game

(** Raised when an unknown direction is encountered*)
exception UnknownMovement of string

(** Raised when deadend is encountered*)
exception DeadEnd

(** [game_json json pokedex] is the [game] represented by [json].
    [pokedex] is used to obtain pokemon in the game.*)
val game_json: Yojson.Basic.t -> Pokemon.t -> game

(** [get_room g s] is the room with name [s] in game [g] 
    Raises: [Failure] with an unspecified error message if [s] is not a valid 
    room name.
    Raises: [DeadEnd] if [s] is the empty string.*)
val get_room:  game -> string -> room

(** [start_room g] is the starting room of game [g] *)
val start_room: game -> room

(** [get_char rm s] is the character in room [rm] with name [s]
    Raises: [Failure] with an unspecified error message if [s] is not in 
    room [rm].*)
val get_char:  room -> string -> character

(** [valid_char rm s] returns true iff character [s] is in room [r] *)
val valid_char:  room -> string -> bool

(** [get_room_chars rm] is the list of character names in room [rm]*)
val get_room_chars:  room -> string list

(** [char_pokemon ch] is the pokemon of character [ch]*)
val char_pokemon: character -> pokemon

(** [room_name r] is the name of room [r]*)
val room_name: room -> string

(** [room_desc g r] is the description of the room named [r] in game g*)
val room_desc: game -> string -> string

(** [elite3 g] returns the 'elite 3' opponents in game [g] in the right order*)
val elite3: game -> string list

(** [pokemon_center r] evaluates to true/false depending on if the room has 
    a pokemon center*)
val pokemon_center: room -> bool

(** [roster_length g] returns the roster length in game [g]*)
val roster_length: game -> int

(** [in_elite3 g ch] returns whether the character named [ch] is in the 
    'elite 3'*)
val in_elite3: game -> string -> bool

(** [char_diff g ch] returns all non-elite character names which are not in 
    [ch] but are in game [g] *)
val char_diff: game -> string list -> string list

(** [get_char_room c g] returns the room which character [c] is in in game [g].
    Raises: [Failure] with an unspecified error message if the character [c] 
    is not in any room.
*)
val get_char_room: string -> game -> string

(** [room_to_visit g r s]  is the room to visit in game [g] when one moves
    in the direction [s] in room [r]
    Raises: UnknownMovement if [s] is not a cardinal direction.
    Raises: DeadEnd if the direction [s] leads to a dead end.*)
val room_to_visit: game -> room -> string ->room

(** [list_chars g] returns a list of all character names in game [g]*)
val list_chars : game -> string list

(** [non_elites g] returns a list of all non-elite character names in game [g]*)
val non_elites: game -> string list