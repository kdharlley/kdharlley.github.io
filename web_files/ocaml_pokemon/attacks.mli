(**  Representation of static attack data.

     This module represents the data stored in attack files,
     including the attack names and description. It handles loading of that 
     data from JSON as well as querying the data. *)

open Types

(** The abstract type of values representing an attack.*)
type attack

(** The abstract type of the set representing all valid attacks in the game. *)
type t

(** [attack_dict j] is the set of attacks that [j] represents.
    Requires: [j] is a valid JSON attack set representation. *)
val attack_dict : Yojson.Basic.t -> t

(** [get_elemtype atk] is the [elemtype] of [atk].*)
val get_elemtype : attack -> elemtype

(** [atk_dmg_dict s a] is the damage give by attack with name [s] 
    as defined in the attack directory [a].*)
val atk_dmg_dict : string -> t -> int

(** [atk_dmg a] is the damage of attack [a].*)
val atk_dmg :  attack -> float

(** [atk_accu s a] is the accuracy of the attack with name [s] as defined
    in the attack directory [a].*)
val atk_accu : string ->  t -> float

(** [atk_desc s a] is the description of the attack with name [s] as defined 
    in the attack directory [a].*)
val atk_desc : string ->  t ->  string

(** [get_atk s a] is the attack with name [s] as defined in the attack 
    directory [a].
    Raises: [Failure] with an unspecified error message if [s] is not a valid 
    attack*)
val get_atk : string ->  t -> attack

(** [get_accuracy a] returns the accuracy of the attack [a] *)
val get_accuracy : attack -> int
