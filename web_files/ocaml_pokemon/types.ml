(* extra data stores what is most effective against pokemno *)
type elemtype = 
  |Normal
  |Normext
  |Fire
  |Water
  |Grass
  |Electric
  |Ice
  |Fighting
  |Poison
  |Flying
  |Ground
  |ErroneousType

let type_to_int t =
  match t with
  |Normal -> 0
  |Fire -> 1
  |Water -> 2
  |Grass -> 3
  |Electric -> 4
  |Ice -> 5
  |Fighting -> 6
  |Poison -> 7
  |Ground -> 8
  |Flying -> 9
  |Normext -> 10
  |ErroneousType -> failwith "This isn't a valid type"

let type_to_string t =
  match t with
  |Normal -> "normal"
  |Fire -> "fire"
  |Water -> "water"
  |Grass -> "grass"
  |Electric -> "electric"
  |Ice -> "ice"
  |Fighting -> "fighting"
  |Poison -> "poison"
  |Flying -> "flying"
  |Ground -> "ground"
  |Normext -> "normext"
  |ErroneousType -> failwith "This isn't a valid type"

let string_to_type s = 
  let s = String.lowercase_ascii s in
  if s = "fire" then Fire else
  if s = "water" then Water else
  if s = "grass" then Grass else
  if s = "normal" then Normal  else
  if s = "normext" then Normext else
  if s = "electric" then Electric  else
  if s = "ice" then Ice else
  if s = "fighting" then Fighting else
  if s = "poison" then Poison else 
  if s = "ground" then Ground else
  if s = "normext" then Normext else
  if s= "flying" then Flying else ErroneousType

let int_to_type i = 
  if i = 1 then Fire else
  if i = 2 then Water else
  if i = 3 then Grass else
  if i = 4 then Normal  else
  if i = 5 then Electric else
  if i = 6 then Ice else
  if i = 7 then Fighting else 
  if i = 8 then Poison else 
  if i= 9 then Flying else
  if i = 10 then Normext else ErroneousType

(** [effechart] is a chart used to represent how effective one type is against
    another type. *)
let effecchart : float array array  = 
  (** Normal*)  [|[|1.0;1.0;1.0;1.0;1.0;1.0;1.0;1.0;1.0;1.0;100.0|];
                  (** Fire*)      [|1.0;0.5;0.5;2.0;1.0;2.0;1.0;1.0;1.0;1.0|];
                  (** Water*)     [|1.0;2.0;0.5;0.5;1.0;1.0;1.0;1.0;2.0;1.0|];
                  (** Grass*)     [|1.0;0.5;2.0;0.5;1.0;1.0;1.0;0.5;2.0;0.5|];
                  (** Electric*)  [|1.0;1.0;2.0;0.5;0.5;1.0;1.0;1.0;0.0;1.0|];
                  (** Ice*)       [|1.0;0.5;0.5;2.0;1.0;0.5;1.0;1.0;2.0;2.0|];
                  (** Fighting*)  [|2.0;1.0;1.0;1.0;1.0;0.5;2.0;1.0;0.5;1.0|];
                  (** Poison*)    [|1.0;1.0;1.0;2.0;1.0;1.0;1.0;0.5;0.5;1.0|];
                  (** Ground*)    [|1.0;2.0;1.0;0.5;2.0;1.0;1.0;2.0;1.0;0.0|];
                  (** Flying*)    [|1.0;2.0;1.0;2.0;0.5;1.0;2.0;1.0;1.0;1.0|];
                |]

let effectiveness (t1:elemtype) (t2:elemtype) =
  Array.get (Array.get effecchart (type_to_int t1)) (type_to_int t2)

let valid_type s =
  if string_to_type s = ErroneousType then false else true








