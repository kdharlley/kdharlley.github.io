(********************************************************************
   Test Plan.

    We had a very comprehensive test plan. Using blackbox testing, we included
    a unit test for almost every function defined in interfaces in OUnit. 
    Though some functions for example get_pokemon were not explicitly tested, 
    they were called when testing other functions which gave us confidence they 
    worked properly. Other non-deterministic functions or functions which
    included non-determinism like random_pokemon, were not tested to avoid the 
    inclusion of flaky tests. All in all OUnit tests were included for all 
    functions defined in mli, barring special or extenuating circumstances. 
    By including a test for every function, we gained pretty large confidence 
    that in most scenarios, functions would behave as excepted. To further,
    ensure said functions were accurate, extensive white-box testing was
    performed manually by actually playing the game and observing the behaviour
    for multiple different game paths. Also, manual testing was used to test 
    non-deterministic functions to ensure the functions worked exactly how 
    its spec described it(black-box testing) as well as to 
    ensure all code was reached and behaved as expected(white-box testing).
    We attempted to white-box test as many functions manually as the game 
    would allow. By using both white-box testing and black-box testing, we
    assured ourselves both the promised behavior as well as our
    intended behavior as outlined in the code was fulfilled. By also using a 
    combination of manual and automatic testing, we were able to test very 
    large portions of the codebase as well as ensure that the game worked how
    we wanted for users. Through this combination of white-box testing, black-
    box testing, automatic testing and manual testing, we believe with 
    relatively high confidence that our system delivers what we promise as
    well as what we intended. To be more explicit with testing, for each module
    we shall specify how it was tested below with respect to OUnit testing or
    manual testing. There still might be some special functions  in modules
    which might not have been able to be able to be tested by OUnit or manual 
    testing for reasons already outlined above, but generally the method or 
    methods were used to at least partly test the module
    State -> OUnit and Manual Testing
    Types -> OUnit and Manual Testing
    Pokemon -> OUnit and Manual Testing
    Main -> Manual Testing. (As a result of the functions in this module, 
    we could only test it manually.)
    Gameworld -> OUnit and Manual Testing
     Attacks -> OUnit and Manual Testing

 *****************************************************************)

open OUnit2
open Attacks
open Pokemon
open Command
open State
open Types
open Gameworld

(********************************************************************
   Here are some helper functions for your testing of set-like lists. 
 ********************************************************************)


(** [make_stats_test name input pkm_name func 
    expected_output] constructs an OUnit test named [name] that asserts the 
    quality of [expected_output] with [ func  pkm_name input ]. *)
let make_stats_test  
    (name: string) 
    (input: Yojson.Basic.t)
    (pkm_name: string)
    (func: 'a -> 'b)
    (expected_output: 'b) : test = 
  name >:: (fun _ -> 
      (* the [printer] tells OUnit how to convert the output to a string *)
      assert_equal expected_output (func (get_pokemon (from_json input) 
                                            pkm_name)) )


(** [make_pkm_test name pkm func 
    expected_output] constructs an OUnit test named [name] that asserts the 
    quality of [expected_output] with [ func pkm  ]. *)
let make_pkm_test  
    (name: string) 
    (pkm: pokemon)
    (func: 'a -> 'b)
    (expected_output: 'b) : test = 
  name >:: (fun _ -> 
      (* the [printer] tells OUnit how to convert the output to a string *)
      assert_equal expected_output (func pkm) )

(** [make_atk_test name atk func 
    expected_output] constructs an OUnit test named [name] that asserts the 
    quality of [expected_output] with [func atk ]. *)
let make_atk_test  
    (name: string) 
    (atk: attack)
    (func: 'a -> 'b)
    (expected_output: 'b) : test = 
  name >:: (fun _ -> 
      (* the [printer] tells OUnit how to convert the output to a string *)
      assert_equal expected_output (func atk) )

(** [make_mul_test name input1 input2 func 
    expected_output] constructs an OUnit test named [name] that asserts the 
    quality of [expected_output] with [func  input1 input2]. *)
let make_mul_test  
    (name: string) 
    (input1: 'a)
    (input2: 'b)
    (func: 'c)
    (expected_output: 'd) : test = 
  name >:: (fun _ -> 
      (* the [printer] tells OUnit how to convert the output to a string *)
      assert_equal expected_output (func input1 input2) )

(** [make_sing_test name input1 func 
    expected_output] constructs an OUnit test named [name] that asserts the 
    quality of [expected_output] with [func input1 ]. *)
let make_sing_test  
    (name: string) 
    (input1: 'a)
    (func: 'c)
    (expected_output: 'd) : test = 
  name >:: (fun _ -> 
      assert_equal expected_output (func input1) )

let make_type_tests
    (name:string)
    (atype:string)
    (dtype:string)
    (expected_output:float) : test = 
  name >:: (fun _ ->
      assert_equal expected_output (effectiveness (string_to_type atype) 
                                      (string_to_type dtype)))

let make_game_tests
    (name:string)
    (game: Gameworld.game)
    (f: 'a)
    (expected_output: 'b) : test =
  name >:: (fun _ ->
      assert_equal expected_output (f game))

let string_game_tests
    (name:string)
    (game: Gameworld.game)
    (strin: string)
    (f: 'a)
    (expected_output: 'b) : test =
  name >:: (fun _ ->
      assert_equal expected_output (f game strin))

let make_legal_state_test 
    (name:string)
    (game: Gameworld.game)
    (s: string)
    (st: State.t)
    (expected_output: 'b) : test =
  name >:: (fun _ ->
      match (go s game st) with 
      | Illegal -> assert_failure "you failed"
      | Legal t-> 
        assert_equal expected_output (room_name (current_room t)) )

let make_illegal_state_test 
    (name:string)
    (game: Gameworld.game)
    (s: string)
    (st: State.t) : test =
  name >:: (fun _ ->
      assert_equal Illegal (go s game st)
    )

let pokedex =(from_json (Yojson.Basic.from_file "pokemon.json"))
let nsew = (game_json (Yojson.Basic.from_file "nsew.json") pokedex) 
let game1 = (game_json (Yojson.Basic.from_file "game1.json") pokedex) 
let state_game1 = init_state game1 pokedex "Pikachu" "Julia"
let state_nsew = init_state nsew pokedex "Pikachu" "Julia"

(** [room3] represents room 3 in game1. *)
let room3 = get_room game1 "room3"

(** [room2] represents room 2 in game1. *)
let room2 = get_room game1 "room2"

(** [room2] represents the character Pat in game1. *)
let pat = get_char (start_room game1) "Pat"

let pokedex = from_json (Yojson.Basic.from_file "pokemon.json")

(** [lvl_pik] is the pokemon pikachu after gaining 160xp. *)
let lvl_pik = add_xp (get_pokemon  pokedex "Pikachu") 160 

(** [mlvl_pik] is the pokemon pikachu after gaining 80xp. *)
let mlvl_pik = add_xp (get_pokemon  pokedex "Pikachu") 80 

(** [mhp_pik] is the pokemon pikachu after sustaining 30 damage. *)
let mhp_pik = change_hp (get_pokemon  pokedex "Pikachu") ~-30 

(** [hp_pik] is the pokemon pikachu after sustaining 30 damage 
    and being healed.*)
let hp_pik = change_hp (get_pokemon  pokedex "Pikachu") ~-30  |> add_hp

(** [up_pik] is [lvl_pik] after deating [mlvl_pik] *)
let up_pik = update_lvl lvl_pik mlvl_pik

let atk_dict = attack_dict (Yojson.Basic.from_file "attacks.json")

(** [acid] is the attack type named "Growl" in the attacks.json *)
let growl = Attacks.get_atk "Growl" atk_dict

(** [win_julia] is Julia's state after she has defeated all 6 trainers*)
let win_julia =
  let all_chars = ["Pat"; "Ash"; "Joe"; "Ken"; "Aidan"; "Julia" ] in
  List.fold_right defeated_char all_chars state_game1

(** [mid_julia] is Julia's state after she has defeated all trainers
    except Ken and Pat, with pikachu dead*)
let mid_julia =
  let all_chars = [ "Ash"; "Joe"; "Aidan"; "Julia" ] in
  let fin_st = List.fold_right defeated_char all_chars state_game1 in
  update_pokemon fin_st (change_hp hp_pik ~-100)
(********************************************************************
   End helper functions.
 ********************************************************************)


let pokemon_tests =
  [
    make_legal_state_test "go east" game1 "east" state_game1 "room2";
    make_legal_state_test "go north" nsew "north" state_nsew "room_2";
    make_legal_state_test "go east" nsew "east" state_nsew "room_3";
    make_illegal_state_test "go south (elite!)" game1 "south" state_game1 ;
    make_game_tests "chars in nsew" nsew list_chars 
      ["Noah"; "Nick"; "Duncan"; "Ken"; "Aidan"; "Julia" ];
    make_game_tests "chars in game1" game1 list_chars 
      ["Pat"; "Ash"; "Joe"; "Ken"; "Aidan"; "Julia" ];
    make_game_tests "elite 3 in nsew" nsew elite3 
      [ "Ken"; "Aidan"; "Julia" ];
    make_game_tests "elite 3 in game1" game1 elite3 
      [ "Ken"; "Aidan"; "Julia" ];
    make_game_tests "non-elite 3 in nsew" nsew non_elites 
      [ "Noah"; "Nick"; "Duncan"];
    make_game_tests "non-elite 3 in game1" game1 non_elites 
      [ "Pat"; "Ash"; "Joe" ];
    make_game_tests "roster length game1" game1 roster_length  4;
    make_game_tests "roster length nsew" nsew roster_length 4;
    string_game_tests "game1 room description" game1 "room2" room_desc
      "Woah, there are some dudes here. Why don't you check them out? \
       \n This is room 2";
    string_game_tests "nsew room description" nsew "room_2" room_desc
      "woah! another place! go catch em all dude";
    string_game_tests "Julia is in elite3" game1 "Julia" in_elite3
      true;
    string_game_tests "Noah is not in elite3" nsew "Noah" in_elite3
      false;
    make_type_tests "fire to water" "fire" "water" 0.5;
    make_type_tests "ground to flying" "ground" "flying" 0.0;
    make_type_tests "ice to ground" "ice" "ground" 2.0;
    make_type_tests "electric to ground" "electric" "ground" 0.0;
    make_type_tests "fire to grass" "fire" "grass" 2.0;
    make_type_tests "grass to water" "grass" "water" 2.0;
    make_type_tests "water to fire" "water" "fire" 2.0;
    make_type_tests "normal to normal" "normal" "normal" 1.0;
    make_type_tests "water to ground" "water" "ground" 2.0;
    make_type_tests "ice to fighting" "ice" "fighting" 1.0;
    make_type_tests "extraneous normal" "normal" "normext" 100.0;
    make_type_tests "grass to ground" "grass" "ground"  2.0;
    make_type_tests "fighting to normal" "fighting" "normal" 2.0;
    make_type_tests "ice to water" "ice" "water" 0.5;
    make_type_tests "ice to grass" "ice" "grass" 2.0;
    make_type_tests "ground to grass" "ground" "grass" 0.5;
    make_type_tests "ice to fire" "ice" "fire" 0.5;
    make_type_tests "flying to fire" "flying" "fire" 2.0;
    make_type_tests "fire to ground" "fire" "ground" 1.0;
    make_stats_test "Pikachu HP"  
      (Yojson.Basic.from_file "pokemon.json") "Pikachu" get_hp 45;
    make_stats_test "Ivysaur HP" 
      (Yojson.Basic.from_file "pokemon.json") "Ivysaur" get_hp 60;
    make_stats_test "Bulbasaur attack" 
      (Yojson.Basic.from_file "pokemon.json") "Bulbasaur" get_atk 49;
    make_stats_test "Ivysaur attack" 
      (Yojson.Basic.from_file "pokemon.json") "Ivysaur" get_atk 62;
    make_stats_test "check xp initialized to zero" 
      (Yojson.Basic.from_file "pokemon.json") "Ivysaur" get_xp 0;
    make_stats_test "Bulbasaur HP same as max" 
      (Yojson.Basic.from_file "pokemon.json") "Bulbasaur" get_max_hp 45;
    make_stats_test "Ivysaur HP same as max" 
      (Yojson.Basic.from_file "pokemon.json") "Ivysaur" get_max_hp 60;
    make_stats_test "Bulbasaur name" 
      (Yojson.Basic.from_file "pokemon.json") "Bulbasaur" get_name "Bulbasaur";
    make_stats_test "Ivysaur name" 
      (Yojson.Basic.from_file "pokemon.json") "Ivysaur" get_name "Ivysaur";
    make_stats_test "Bulbasaur description" 
      (Yojson.Basic.from_file "pokemon.json") "Bulbasaur" get_description
      "Bulbasaur can be seen napping in bright sunlight. There is a seed on \
       its back. By soaking up the sun's rays, the seed grows progressively \
       larger.";
    make_stats_test "Ivysaur description" 
      (Yojson.Basic.from_file "pokemon.json") "Ivysaur" get_description 
      "There is a bud on this Pokémon's back. To support its weight, \
       Ivysaur's legs and trunk grow thick and strong. If it starts \
       spending more time lying in the sunlight, it's a sign that the \
       bud will bloom into a large flower soon.";
    make_stats_test "Ivysaur name" 
      (Yojson.Basic.from_file "pokemon.json") "Ivysaur" ready_to_level_up
      false;
    make_pkm_test "Pikcahu level up" 
      lvl_pik ready_to_level_up true;
    make_pkm_test "Pikachu xp check" 
      mlvl_pik get_xp 80;
    make_pkm_test "change Pikachu hp check" 
      mhp_pik get_hp 15;
    make_pkm_test "add Pikachu hp check" 
      hp_pik get_hp 45;
    make_pkm_test "heal Pikachu hp check" 
      (mhp_pik |> heal_pokemon) get_hp 45;
    make_pkm_test "heal Pikachu hp check" 
      (hp_pik |> heal_pokemon) get_hp 45;
    make_pkm_test "Pikachu death test" 
      (change_hp hp_pik ~-50) is_dead true;
    make_pkm_test "Pikachu alive test" 
      (change_hp hp_pik ~-20) is_dead false;
    make_pkm_test "Pikachu moves test" 
      hp_pik get_attacks_list ["Growl"; "Thunderbolt"; "Quick Attack"; 
                               "Tail Whip"; "Mega Kick" ];
    make_stats_test "Ivysaur moves" (Yojson.Basic.from_file "pokemon.json") 
      "Ivysaur" get_attacks_list ["Vine Whip";"Twineedle";"Mega Drain"];
    make_mul_test "Valid move test" ["Growl"; "Thunderbolt";] "Thunderbolt" 
      valid_move true;
    make_mul_test "Invalid move test" ["Growl"; "Sunny Day";] "Thunderbolt" 
      valid_move false;
    make_pkm_test "Pikachu alive test" 
      (lvl_pik |> level_up) get_level 11;
    make_pkm_test "Testing level up" 
      up_pik get_level 11;
    make_pkm_test "Testing xp reset" 
      up_pik get_xp 0;
    make_atk_test "Growl accuracy test" growl get_accuracy 100;
    make_atk_test "Growl element type test" growl get_elemtype 
      (string_to_type "Normal");
    make_mul_test "Slam damage string test" "Slam" atk_dict atk_dmg_dict 80;
    make_mul_test "Slam accuracy string test" "Slam" atk_dict atk_accu 75.0;
    make_mul_test "Slam accuracy string test" "Slam" atk_dict atk_desc "Slam";
    make_atk_test "Growl damage test" growl atk_dmg 40.0;
    make_sing_test "Element Type Int Test" (string_to_type "fire") 
      type_to_int 1;
    make_sing_test "Element Type Int Test Reverse" 1
      int_to_type (string_to_type "fire") ;
    make_sing_test "Element Type to String test" (get_elemtype growl)
      type_to_string "normal" ;
    make_sing_test "Normal Valid Type Test" "Normal"
      valid_type true ;
    make_sing_test "Cat Valid type test" "cat"
      valid_type false ;
    make_sing_test "Pokemon Center Test" room3
      pokemon_center true ;
    make_sing_test "Pokemon Center Test start room" (start_room game1)
      pokemon_center false ;
    make_sing_test "Start Room Test" (start_room game1)
      room_name "room1" ;
    make_mul_test "Checking pat is in room1" (start_room game1) "Pat"
      valid_char true;
    make_mul_test "Checking ash is  not in room1" (start_room game1) "Ash"
      valid_char false;
    make_sing_test "Charmander is pat's pokemon test" (char_pokemon pat)
      get_name "Charmander" ;
    make_mul_test "Correct identification of non-elite characters test"
      game1 [ "Pat"; "Ash"; ] char_diff ["Joe";] ;
    make_mul_test "Correct identification of non-elite characters test"
      game1 [] char_diff [ "Pat"; "Ash"; "Joe";] ;
    make_mul_test "Testing ash is in room 2"
      "Ash" game1  get_char_room "room2";
    make_mul_test "Testing room2 is east of room1"
      (start_room game1) "east" (room_to_visit game1) room2;
    make_sing_test "Testing Julia's pokemon is pikachu" state_game1 
      curr_pokemon hp_pik;
    make_sing_test "Testing Julia's name is julia" state_game1 
      player_name "Julia";
    make_sing_test "Testing win when elite3 is defeated" win_julia 
      (game_over game1) true;
    make_sing_test "Testing win when elite3 is defeated" mid_julia 
      (game_over game1) false;
    make_sing_test "Testing Julia's pikachu alive at end" "Pikachu"
      (in_alive win_julia) true;
    make_sing_test "Testing Julia's pikachu dead in the middle" "Pikachu"
      (in_alive mid_julia) false;
    make_sing_test "Testing Julia has living pokemon " mid_julia
      pokemon_left true;
    make_sing_test "Testing switching to Julia's pikachu" 
      (switch_poke state_game1 "Pikachu") curr_pokemon hp_pik;
    make_sing_test "Testing at end no non-elite characters undefeated" 
      win_julia (chars_left game1) [];
    make_sing_test "Testing in middle Pat is only non-elite undefeated" 
      mid_julia (chars_left game1) ["Pat";];
    make_sing_test "Testing at end no characters undefeated in start room" 
      win_julia (opps_left game1) [];
    make_sing_test "Testing in middle Pat undefeated in start room" 
      mid_julia (opps_left game1) ["Pat"];
    make_mul_test "Testing can heal Julia's pikachu" 
      (curr_pokemon mid_julia) mid_julia try_to_heal (Some hp_pik);
    make_sing_test "Testing at end no trainers to defeat" 
      win_julia (stringify_opps game1) "";
    make_sing_test "Testing in middle Pat needs to be defeated" 
      mid_julia (stringify_opps game1) "Pat is in room1\n";
    make_sing_test "Testing leveling pikachu twice accurate" 
      (lvlpkmn 2 hp_pik) get_level 12;
    make_sing_test "Testing leveling pikachu zero accurate" 
      (lvlpkmn 0 hp_pik) get_level 10;
    make_sing_test "parsing go command" 
      "go east" parse (Go ["east"]);
    make_sing_test "parsing challenge command" 
      "challenge Ash" parse (Challenge ["Ash"]);
    make_sing_test "parsing heal command" 
      "heal Pikachu" parse (Heal ["Pikachu"]);
    make_sing_test "parsing quit command" 
      "quit" parse Quit;
    make_sing_test "parsing battle command" 
      "battle" parse Battle;
    make_sing_test "parsing run command" 
      "run" parse Run;
    make_sing_test "parsing observe command" 
      "observe" parse Observe;
    make_sing_test "parsing pokemon stats command" 
      "stats" parse PokemonStats;
    make_sing_test "parsing switch command" 
      "switch" parse Switch;
    make_sing_test "parsing search command" 
      "search" parse Search;
    make_sing_test "parsing opps command" 
      "opps" parse Opps;
    make_sing_test "parsing rules command" 
      "rules" parse Rules;
  ]

let suite =
  "test suite for Pokemon Project"  >::: List.flatten [
    pokemon_tests;
  ]

let _ = run_test_tt_main suite
