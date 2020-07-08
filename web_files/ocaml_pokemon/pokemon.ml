open Yojson.Basic.Util
open Types
open Attacks
open Random


(** The abstract type of values representing a pokemon's stats *)
type stats = {max_hp: int; current_hp: int; attack: int;
              defense: int; sp_attack:int; sp_def: int; speed: int;}


type pokemon = {
  name: string;
  poketype: elemtype;
  description: string;
  level : int;
  xp : int;
  attacks: string list ;
  stats:  stats;
}

(** [stats_json json] is the [stats] represented by [json]. This
    method creates a stats object from the given json. *)
let stats_json json = {
  max_hp = json |> member "HP" |> to_int;
  current_hp = json |> member "HP" |> to_int;
  attack = json |> member "Attack" |> to_int;
  defense = json |> member "Defense" |> to_int;
  sp_attack = json |> member "Sp. Attack" |> to_int;
  sp_def = json |> member "Sp. Defense" |> to_int;
  speed = json |> member "Speed" |> to_int;
}

(** [pokemon_from_json json] is the [pokemon] represented by [json] *)
let pokemon_from_json json = {
  name = json |> member "name" |> to_string;
  poketype = json |> member "type" |> to_string |> string_to_type ;
  description = json |> member "description" |> to_string ;
  stats = json |> member "base" |>  stats_json;
  level = 10;
  xp = 0;
  attacks = json |> member "attacks" |>  to_list |> List.map to_string;
}

(** [poke_list json] is the list of [pokemon] represented by [json] *)
let poke_list json =
  json |> to_list |> List.map pokemon_from_json

(** A [PokemonMap] maps pokemon names to [pokemon]. *)
module PokemonMap = Map.Make (struct
    type t = string
    let compare = Stdlib.compare
  end
  )

(** [make_poke_dict p_lst pokedex] is a [PokemonMap] containing all the pokemon
    in [p_lst], where [pokedex] is the current running total of pokemon.*)
let rec make_poke_dict p_lst pokedex =
  match p_lst with
  | [] -> pokedex
  | h::t -> make_poke_dict t PokemonMap.(add h.name h pokedex)

(** [pokedex json] is the [PokemonMap] that [json] represents.
    Requires: [j] is a valid JSON pokedex representation. *)
let pokedex json= make_poke_dict (poke_list json) PokemonMap.empty

type t = pokemon PokemonMap.t

let from_json json =
  pokedex json

let get_name (p:pokemon)=
  p.name

let get_atk (p:pokemon)=
  p.stats.attack

(** [get_atk_float p] returns the attack stat of pokemon [p] as a float *)
let get_atk_float p =
  float_of_int p.stats.attack

let get_type (p:pokemon)=
  p.poketype

let get_hp p =
  p.stats.current_hp

(** [get_hp_float p] returns the hp stat of pokemon [p] as a float*) 
let get_hp_float p = 
  float_of_int p.stats.current_hp

let get_xp p =
  p.xp

(** [get_def_float p] returns the defense stat of pokemon [p] as a float*) 
let get_def_float p = 
  float_of_int p.stats.defense

let get_max_hp p =
  p.stats.max_hp

(** [get_max_hp_float p] returns the max hp stat of pokemon [p] as a float*) 
let get_max_hp_float p =
  float_of_int p.stats.max_hp

let get_description p =
  p.description 

let get_level p = 
  p.level

(** [get_level_float p] is the current level of pokemon [p] as a float*) 
let get_level_float p = 
  float_of_int p.level

let ready_to_level_up p =
  p.xp >= int_of_float ((float_of_int p.level)**1.6) 

let add_xp p xp =
  print_endline ("adding xp "^string_of_int xp);
  {p with xp = p.xp + xp}

let add_hp p =
  let new_stats = {p.stats with current_hp = p.stats.max_hp} in 
  { p with stats = new_stats}

let get_attacks_list p =
  p.attacks

let valid_move atks s=
  List.mem s atks 

let change_hp p h =
  let new_stats ={p.stats with current_hp = p.stats.current_hp + h} in
  {p with stats = new_stats}
(* failwith "Unimplementted" *)

let is_dead p =
  p.stats.current_hp <= 0

open PokemonMap

let get_pokemon pokedex p =
  let pokemon = find_opt p pokedex in
  match pokemon with
  | Some v -> v
  | None -> failwith "Pokemon Name not well-defined"

(**[pokemon_of_type_ext s p lst] returns a list of pokemon from pokedex [p] of 
   type [s] where [lst] is a current running total.*) 
let rec pokemon_of_type_ext poke pokelist lst =
  match pokelist with
  | [] -> lst
  | (a, b)::t -> if b.poketype = (string_to_type poke) then begin
      pokemon_of_type_ext poke t (a::lst) 
    end else  pokemon_of_type_ext poke t lst


let rec pokemon_of_type (poke:string) 
    (pokemap: pokemon PokemonMap.t) 
    (lst:string list) = 
  pokemon_of_type_ext poke (bindings pokemap) []
(* match bindings pokemap with *)

let random_pokemon pokemap =
  let _ =  Random.self_init () in 
  let typ = (Random.int 9 + 1) |> int_to_type |> type_to_string in
  let poke_lst = pokemon_of_type typ pokemap [] in
  let r = Random.int (List.length poke_lst) in
  get_pokemon pokemap (List.nth poke_lst r)

let heal_pokemon p =
  add_hp p  

(* Change this to implement random attacks *)
let opp_move attks =
  let _ =  Random.self_init () in
  let n = (List.length attks)-1 in
  let i = Random.int n in
  List.nth attks i

(** [attack_hit a] is truee iff the attack [a] successfult hits an opponent, a
    random outcome dependent on [a]'s accuracy. *)
let attack_hit att : bool = 
  let roll = Random.int 99 in
  if (100 - get_accuracy att) > roll then begin
    print_endline ("Your attack missed"); false end
  else true

let damage_done (attacker:pokemon) (defender:pokemon) (att:attack) : int =
  let type_mult = effectiveness (get_elemtype att) (get_type defender) in
  let atklvl = get_level_float attacker in
  let a = get_atk_float attacker in
  let power = (atk_dmg att)/.2.0 in
  let d = get_def_float defender in
  if attack_hit att 
  then int_of_float 
      (type_mult *. (((2.0*.atklvl /. 5.0) +. 2.0) *. power *. (a/.d))/.8.0)
  else 0

let pokemon_attack (attacker:pokemon) (defender:pokemon) (att:attack)  =
  let attk_dmg = damage_done attacker defender att in
  let pk2_attkd = change_hp defender (~-attk_dmg) in
  pk2_attkd

(** [level_stats st] represents the new stats of a pokemon with stats [st], 
    after it has leveled up.*)
let level_stats (stats:stats) : stats = 
  let hp_incr = (Random.int stats.max_hp)/6 + 2 in
  let atk_incr = (Random.int stats.attack)/15 in
  let def_incr = (Random.int stats.defense)/15 in
  let spatk_incr = (Random.int stats.sp_attack)/15 in
  let spdef_incr = (Random.int stats.sp_def)/15 in
  let spd_incr = (Random.int stats.speed)/15 in
  {
    max_hp = stats.max_hp + hp_incr;
    current_hp = stats.current_hp + hp_incr;
    attack = stats.attack + atk_incr;
    defense = stats.defense + def_incr;
    sp_attack = stats.sp_attack + spatk_incr;
    sp_def = stats.sp_def + spdef_incr;
    speed = stats.speed + spd_incr;
  }

let level_up (original:pokemon) : (pokemon) = {
  name = original.name;
  poketype = original.poketype;
  description = original.description;
  level = original.level + 1;
  xp = 0;
  attacks = original.attacks;
  stats = level_stats original.stats
}

let update_lvl (original:pokemon) (defeated:pokemon) : (pokemon) = 
  let xp_gained = (get_level defeated) * 2 in 
  let xpmypkmn = add_xp original xp_gained in
  if ready_to_level_up xpmypkmn then level_up original
  else xpmypkmn
