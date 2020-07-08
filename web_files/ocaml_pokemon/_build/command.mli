(**   Parsing of player commands.*)


(** The type [object_phrase] represents the object phrase that can be part of a 
    player command.  The list is in the same order as the words 
    in the original player command and is never empty.  *)
type object_phrase = string list

(** The type [command] represents a player command that is decomposed
    into a verb and possibly an object phrase. *)
type command = 
  | Go of object_phrase
  | Quit
  | Battle 
  | Run
  | Observe
  | Challenge of object_phrase
  | PokemonStats
  | Switch
  | Search
  | Heal of object_phrase
  | Opps
  | Rules

(** Raised when an empty command is parsed. *)
exception Empty

(** Raised when a malformed command is encountered. *)
exception Malformed

(** [parse str] parses a player's input into a [command], as follows. The first
    word of [str] becomes the verb. The rest of the words, if any, become the 
    object phrase.
    Requires: [str] contains only alphanumeric (A-Z, a-z, 0-9) and space 
    characters (only ASCII character code 32; not tabs or newlines, etc.).
    Raises: [Empty] if [str] is the empty string or contains only spaces. 
    Raises: [Malformed] if the command is malformed. A command
    is {i malformed} if the verb isnt associated with a command, or if the 
    command is missing its object phrase.*)
val parse : string -> command
