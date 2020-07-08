type object_phrase = string list

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


exception Empty

exception Malformed

(** [remove_spaces str_list ongoing_list] is [str_list] with all elements 
    which are empty strings removed where [ongoing_list] is the computed value
    so far. *)
let rec remove_spaces str_list ongoing_list=
  match str_list with
  | [] -> List.rev ongoing_list
  | h::t -> 
    if h = "" then remove_spaces t ongoing_list else 
      remove_spaces t (h::ongoing_list)


(** [decision str_list] is the command represented by [str_list]
    Raises: [Empty] if [str_list] is the empty list or a list of empty strings
    Raises: [Malformed] if the command represented by [str_list]
     is malformed*)
let decision str_list = 
  let command_list = remove_spaces str_list [] in
  match command_list with
  | [] -> raise Empty
  | h::t -> let tl = String.lowercase_ascii (String.concat " " t)  in
    let hd = String.lowercase_ascii h in
    if hd = "go" && (tl = "north" || tl = "south" || tl = "east" || tl = "west") 
    then Go t else
    if hd = "quit" && List.length t = 0 then Quit else
    if hd = "battle" && List.length t = 0 then Battle else
    if hd = "run" && List.length t = 0 then Run else
    if hd = "observe" && List.length t = 0 then Observe else
    if hd = "challenge" && List.length t > 0 then  Challenge t else
    if hd = "stats" && List.length t = 0 then PokemonStats else
    if hd = "switch" && List.length t = 0 then Switch else
    if hd = "search" && List.length t = 0 then Search else
    if hd = "heal" && List.length t > 0 then Heal t else
    if hd = "opps" && List.length t = 0 then Opps else
    if hd = "rules" && List.length t = 0 then Rules else
      raise Malformed

let parse str =
  decision (String.split_on_char ' ' str) 

