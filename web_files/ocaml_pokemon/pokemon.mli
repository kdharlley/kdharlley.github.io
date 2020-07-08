(**  Representation of static pokemon data.

     This module represents the data stored in pokemon files,
     including the pokemon names and description. It handles loading of that 
     data from JSON as well as querying the data. *)

open Types

(** The abstract type of values representing a pokemon. *)
type pokemon

(** The abstract type of the set representing all valid pokemon in the game. *)
type t

(** [from_json j] is the set of pokemon(pokedex) that [j] represents.
    Requires: [j] is a valid JSON pokedex representation. *)
val from_json : Yojson.Basic.t -> t

(** [get_type p] returns the elemtype of pekemon [p] *) 
val get_type : pokemon -> elemtype

(** [get_hp p] returns the hp of pekemon [p] *) 
val get_hp : pokemon -> int

(** [get_xp p] returns the xp of pekemon [p] *) 
val get_xp : pokemon -> int

(** [get_atk p] returns the attack stat of pokemon [p] *) 
val get_atk : pokemon -> int

(** [get_max_hp p] returns the maximum hp value of a pokemon*)
val get_max_hp : pokemon -> int

(** [get_name p] returns the name of pekemon [p] *) 
val get_name: pokemon -> string

(** [get_description p] returns the description of pekemon [p] *) 
val get_description: pokemon -> string

(** [ready_to_level_up p] returns True iff pokemon [p] jas enough xp to 
    level up *)
val ready_to_level_up: pokemon -> bool

(** [add_xp p i] returns pokemon [p] with its xp increased by [i] *)
val add_xp: pokemon -> int -> pokemon

(** [add_hp p] returns pokemon [p] with its hp restores to full *)
val add_hp: pokemon -> pokemon

(**[pokemon_pf_type s p lst] returns a list of pokemon from pokedex [p] of 
   type [s] where [lst] is the starting value.*) 
val pokemon_of_type: string -> t -> string list-> string list

(**[random_pokemon p] returns a random pokemon*) 
val random_pokemon: t -> pokemon

(**[heal_pokemon p] returns same pokemon [p] with full hp*) 
val heal_pokemon: pokemon -> pokemon

(** [get_pokemon p s] returns the pokemon assosciated with the string s 
    according to the pokedex[p] 
    Raises: [Failure] with an unspecified error message if the pokemon [s] 
    is not a valid pokemon in pokedex [p].*) 
val get_pokemon:  t -> string -> pokemon

(** [change_hp p i] returns pokemon [p] with its hp increased by [i] *)
val change_hp: pokemon -> int -> pokemon

(** [is_dead p] returns True iff a pokemon has no or negative health  *)
val is_dead: pokemon -> bool

(** [get_attacks_list p] returns the attacks of pokemon [p].*)
val get_attacks_list: pokemon -> string list

(** [valid_move atks s] returns whether move [s] is in attack list [atks].*)
val valid_move: string list -> string  -> bool

(** [pokemon_attack p1 p2 atk] is pokemon [p2] after taking damage 
    from pokemon [p1] using attack [atk]*)
val pokemon_attack: pokemon -> pokemon -> Attacks.attack -> pokemon

(** [opp_move attks] is a selected attack from the list of attacks [attks] *)  
val opp_move: string list -> string

(** [damage_done attacker defender attack] returns the damage done by a single
    attack provided the attacking pokemon object [attacker], defending pokemon
    object [defender], and the [attack] being used*)
val damage_done: pokemon -> pokemon -> Attacks.attack -> int

(** [level_up pkmn] returns a new pokemon with slightly modified stats
    based on the pokemon [pkmn] passed to it. Used when the pokemon has 
    leveled up at the end of the battle *)
val level_up : pokemon -> pokemon

(** [get_level p] is the current level of pokemon [p] *) 
val get_level : pokemon -> int

(** [update_lvl p1 p2] Updates the pokemon [p1] stats if it satisfies the 
    requirements set by ready_to_level_up which is partly dependent on pokemon
    [p2] *)
val update_lvl : pokemon -> pokemon -> pokemon
