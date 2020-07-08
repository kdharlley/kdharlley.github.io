open Types
open Yojson.Basic.Util

type attack = {
  name : string;
  elemtype : elemtype;
  dmg : int;
  accuracy : int;
  description : string;
}

(** [attack_json json] is the [attack] represented by [json] *)
let attack_json json = {
  name = json |> member "ename" |> to_string;
  elemtype = json |> member "type" |> to_string |> string_to_type;
  dmg = json |> member "power" |> to_int;
  accuracy = json |> member "accuracy" |> to_int;
  description = json |> member "ename" |> to_string;
}

(** [parse_attacks json] is the list of [attack] represented by [json] *)
let parse_attacks json = json |> to_list |> List.map attack_json

(** A [AttackMap] maps attack names to [attack]. *)
module AttackMap = Map.Make (struct
    type t = string
    let compare = Stdlib.compare
  end
  )

let get_elemtype atk =  atk.elemtype

(** [make_attack_dict p_lst pokedex] is a [AttackMap] containing all the attacks
    in [a_lst], where [attack_map] is the current running total of attacks.*)
let rec make_attack_dict a_lst attack_map =
  match a_lst with
  | [] -> attack_map
  | h::t -> make_attack_dict t AttackMap.(add h.name h attack_map)

let attack_dict json= make_attack_dict (parse_attacks json) AttackMap.empty

type t = attack AttackMap.t

open AttackMap

let get_atk a attackdict=
  let attack = find_opt a attackdict in
  match attack with
  | Some v -> v
  | None -> failwith "Attack Name not well-defined"

let atk_dmg_dict a attackdict=
  let attack = get_atk a attackdict in
  attack.dmg 

let atk_dmg a =
  float_of_int a.dmg

let get_accuracy a = 
  a.accuracy

let atk_accu a attackdict  =
  let attack = get_atk a attackdict in
  float_of_int attack.accuracy

let atk_desc a attackdict  =
  let attack = get_atk a attackdict in
  attack.description
