<?php
// vvv DO NOT MODIFY/REMOVE vvv

// check current php version to ensure it meets 2300's requirements

function check_php_version()
{
  if (version_compare(phpversion(), '7.0', '<')) {
    define(VERSION_MESSAGE, "PHP version 7.0 or higher is required for 2300. Make sure you have installed PHP 7 on your computer and have set the correct PHP path in VS Code.");
    echo VERSION_MESSAGE;
    throw VERSION_MESSAGE;
  }
}
check_php_version();

function config_php_errors()
{
  ini_set('display_startup_errors', 1);
  ini_set('display_errors', 0);
  error_reporting(E_ALL);
}
config_php_errors();

// open connection to database
function open_or_init_sqlite_db($db_filename, $init_sql_filename)
{
  if (!file_exists($db_filename)) {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (file_exists($init_sql_filename)) {
      $db_init_sql = file_get_contents($init_sql_filename);
      try {
        $result = $db->exec($db_init_sql);
        if ($result) {
          return $db;
        }
      } catch (PDOException $exception) {
        // If we had an error, then the DB did not initialize properly,
        // so let's delete it!
        unlink($db_filename);
        throw $exception;
      }
    } else {
      unlink($db_filename);
    }
  } else {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  }
  return NULL;
}

function exec_sql_query($db, $sql, $params = array())
{
  $query = $db->prepare($sql);
  if ($query and $query->execute($params)) {
    return $query;
  }
  return NULL;
}

// ^^^ DO NOT MODIFY/REMOVE ^^^

// You may place any of your code here.


//this is creating a global variable $db, and this variable opens or initializes cornellLEP.sqilte by using the data from init.sql
$db = open_or_init_sqlite_db('secure/cornelllep.sqlite','secure/init.sql');

// this function decides how long a user can log in for. eg, mine here sets 2 hours.
define('SESSION_COOKIE_DURATION', 60*60*2);
$session_messages = array();

function log_in($username, $password) {
  global $db;
  global $current_user;
  global $session_messages;

   // this function  logs in user with user name and user password
  if ( isset($username) && isset($password) ) {
    //With the known username, this part check if the password matches with the one that this user has in the database
    $sql = "SELECT * FROM users WHERE username = :username;";
    $params = array(
      ':username' => $username
    );
    $records = exec_sql_query($db, $sql, $params)->fetchAll();
    if ($records) {
      $account = $records[0];
      if ( password_verify($password, $account['password']) ) {
        $session = session_create_id();
        $sql = "INSERT INTO sessions (user_id, session) VALUES (:user_id, :session);";
        $params = array(
          ':user_id' => $account['id'],
          ':session' => $session
        );
        $result = exec_sql_query($db, $sql, $params);
        if ($result) {
          setcookie("session", $session, time() + SESSION_COOKIE_DURATION);
          $current_user = $account;
          return $current_user;
        } else {
          array_push($session_messages, "Log in failed.");
        }
      } else {
        array_push($session_messages, "Invalid username or password.");
      }
    } else {
      array_push($session_messages, "Invalid username or password.");
    }
  } else {
    array_push($session_messages, "No username or password given.");
  }
  $current_user = NULL;
  return NULL;
}

// this part finds all the information of that user with that known id.
function find_user($user_id) {
  global $db;

  $sql = "SELECT * FROM users WHERE id = :user_id;";
  $params = array(
    ':user_id' => $user_id
  );
  $records = exec_sql_query($db, $sql, $params)->fetchAll();
  if ($records) {
    return $records[0];
  }
  return NULL;
}

//this part return the sesssion information from the known session id.
function find_session($session) {
  global $db;
  // this if statement check if the session is set, if yes, then return corresponding session information.
  if (isset($session)) {
    $sql = "SELECT * FROM sessions WHERE session = :session;";
    $params = array(
      ':session' => $session
    );
    $records = exec_sql_query($db, $sql, $params)->fetchAll();
    if ($records) {
      return $records[0];
    }
  }
  return NULL;
}

//this function returns information of current user and also makes it a global variable so coder can use this variable at any other files in this project.
function session_login() {
  global $db;
  global $current_user;

  // this if statement checks if the cookie session is set or not, if yes, it will return the data of that session.
  if (isset($_COOKIE["session"])) {
    $session = $_COOKIE["session"];

    $session_record = find_session($session);
    // this if statement sets the user id to the current user also it sets time for session cookie duration.
    if ( isset($session_record) ) {
      $current_user = find_user($session_record['user_id']);
      setcookie("session", $session, time() + SESSION_COOKIE_DURATION);
      return $current_user;
    }
  }
  $current_user = NULL;
  return NULL;
}

// this function checks if the user is logged in.
function is_user_logged_in() {
  global $current_user;
  return ($current_user != NULL);
}

// this function log out the current user by making the session cookie duration 0.
function log_out() {
  global $current_user;
  setcookie('session', '', time() - SESSION_COOKIE_DURATION);
  $current_user = NULL;
}

//this part trims user name and user password when the user tries to log in.
if ( isset($_POST['login']) && isset($_POST['user_name']) && isset($_POST['password']) ) {
  $username = trim( $_POST['user_name'] );
  $password = trim( $_POST['password'] );

  log_in($username, $password);
} else {
  session_login();
}

// this part log out the user by checking that the current user is the current user, it is logged in and the user has clicked log out button.
if ( isset($current_user) && ( isset($_GET['logout']) || isset($_POST['logout']) ) ) {
  log_out();
}

// I get log-in log-out code from instrutor Kyle Harms from one of his labs and the lines are from 70 to 198. Source: https://github.coecis.cornell.edu/info2300-sp2019/ys778-lab-08/blob/master/includes/init.php

?>
