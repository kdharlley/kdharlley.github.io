(**  Representation of dynamic game state. 

     This module represents the state of a game as it is being played, 
     including the player's current room, the rooms that have been visited,
     and functions that cause the state to change*)

open Pokemon
open Gameworld

(** The abstract type of values representing the game state. *)
type t 

(** The type representing the resulting state of an attempted movement. *)
type result = Legal of t | Illegal


(** [init_state g p poke player] is the initial state of the game [g]
    with starting pokemon [poke] and a player named [player]. The set of valid
     pokemon in this game are [p]. *)
val init_state: Gameworld.game -> Pokemon.t -> string -> string -> t

(** [curr_pokemon t] is the pokemon of the player in state [t] *)
val curr_pokemon: t -> Pokemon.pokemon

(** [current_room t] is the current room of the player in state [t] *)
val current_room: t -> room

(** [player_name t] is the current name of the player in state [t] *)
val player_name: t -> string

(** [go dir g st] is [r] if attempting to go in the direction [dir] in state 
    [st] and game [g] results in [r] where in [st'] the 
    player is now located in the room to which [dir] leads unless the [dir]
     is a dead end. If the room which the player is about to enter contains an 
     elite 3 member and the player has beaten all characters excluding the 
     elite 3 then [r] is [Legal st'] else it is [Illegal], 
     Raises: DeadEnd if [dir] leads to a deadend. *)
val go: string -> Gameworld.game -> t -> result

(** [update_pokemon st p] is a state with the player's pokemon in state 
    [st] updated to be pokemon [p] *)
val update_pokemon: t-> pokemon -> t

(** [defeated_char st s] is a state with the defeated character [s] added 
    to the player's defeated characters in state [st] *)
val defeated_char:  string -> t -> t

(**[game_over g st] is true iff the user in state [st] has won the game 
   [g] ie. defeated the elite 3.*)
val game_over: Gameworld.game -> t -> bool

(**[stats_string st] is a human-readble string which contains the hp and 
   xp of all pokemon in the player's current roster*)
val stats_string: t -> string

(**[alive_string st] is a human-readble string which contains the hp and
   xp of all living pokemon*)
val alive_string: t -> string

(**[in_alive st s] is true iff pokemon named [s] is in this state's [st] 
   current roster and is alive.*)
val in_alive: t -> string -> bool

(** [switch_poke st p] is a state with the player's current pokemon in state 
    [st] updated to be pokemon [p] *)
val switch_poke: t-> string -> t

(**[pokemon_left st] is true iff there is a pokemon alive in the roster in
   state [st].*)
val pokemon_left: t-> bool

(** [chars_left g st] is the list of non-elite character in game [g] which
    still have to be defeated in state [st]*)
val chars_left: Gameworld.game -> t -> string list

(** [opps_left g st] is the list of characters in the current room in state 
    [st] within game [g] which haven't been defeated. *)
val opps_left: Gameworld.game -> t  ->string list

(**[wild_pokemon l p] returns a random pokemon option from the set of pokemon
   [p] levelled up [l] times.*)  
val wild_pokemon: int -> Pokemon.t -> Pokemon.pokemon option

(**[try_to_heal p st] returns pokemon [p] in the roster [st] with increased hp 
   as an option if it is one of the player's pokemon in state [st] or None if 
   the player does not have that pokemon.  *)
val try_to_heal : Pokemon.pokemon -> t -> Pokemon.pokemon option

(** [stringify_opps g st] is a string containing the non-elite trainers left 
    unbeaten in [st] and the rooms they are in in game [g] *)
val stringify_opps : Gameworld.game -> t -> string

(** [lvlpkmn int pkmn] levels up pokemon [pkmn],  [int] times *)
val lvlpkmn : int -> Pokemon.pokemon -> Pokemon.pokemon

(** [update_roster p st] replaces pokemon [p] in the player's roster in [st].*)
val update_roster : Pokemon.pokemon -> t -> t