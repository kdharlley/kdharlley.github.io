(**  Representation of static type data.

     This module represents types, including conversions from strings
     to types and types to strings.  *)

(** The abstract type representing a pokemon's type. *)
type elemtype 

(** [effectiveness t1 t2] Calculates the effectiveness of an attack type [t1]
    to a defending pkm type [t2]*)
val effectiveness : elemtype -> elemtype -> float

(** [type_to_int t] is the int associated with the elemtype [t].
     Raises: [Failure] with an unspecified error message if the elemtype [t] 
    is not a valid type representation. *)
val type_to_int : elemtype -> int

(** [type_to_string t] is the string assocaited with elemtype [t]. 
     Raises: [Failure] with an unspecified error message if the elemtype [t] 
    is not a valid type representation.*) 
val type_to_string : elemtype -> string

(** [string_to_type s] is the elemtype assosciated with the string [s]*)
val string_to_type : string -> elemtype

(** [int_to_type i] is the type associated with the int [i] *)
val int_to_type : int -> elemtype

(** [valid_type s] returns true iff s is a valid type *)
val valid_type: string -> bool