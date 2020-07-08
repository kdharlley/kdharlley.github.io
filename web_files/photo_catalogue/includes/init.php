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
  return null;
}

function exec_sql_query($db, $sql, $params = array())
{
  $query = $db->prepare($sql);
  if ($query and $query->execute($params)) {
    return $query;
  }
  return null;
}
// ^^^ DO NOT MODIFY/REMOVE ^^^

// You may place any of your code here.

$db = open_or_init_sqlite_db('secure/gallery.sqlite', 'secure/init.sql');


/* Source: Code adapted from Kyle Harm's code in Lab8 */
function log_in($username, $password) {
  global $db;
  global $current_user;

  /* Executes SQL query to obtain all user details with matching username, should return unique record since username unique */
  $sql = "SELECT * FROM users WHERE username = :user_name_login;";
  $params = array(
    ':user_name_login' => $username
  );
  $user_account = exec_sql_query($db, $sql, $params)->fetchAll();

  /*if there is a matching record, the password of the record is checked against the inputted password, since the password is hashed we use a function to accomplish this */
  if ($user_account) {
    $user_record = $user_account[0];

    /* if the passwords match, a session id is generated and stored in the database in a record which corresponds to the user so the server knows who is logged on at a particular time. This session is also given an expiry date which refreshes every 30 minutes*/
    if ( password_verify($password, $user_record['password']) ) {
      $session_id = session_create_id();
      $sql="INSERT INTO sessions (user_id, session) VALUES (:user_id, :session);";
      $params = array(
        ':user_id' => $user_record['id'],
        ':session' => $session_id
      );
      $result = exec_sql_query($db, $sql, $params);
      if ($result) {
        setcookie("session_name", $session_id, time()+1800);
        $current_user = $user_record;
        return $current_user;
      } else {
        $fail=TRUE;
      }
    } else {
      $fail=TRUE;
    }
  } else {
    $fail=TRUE;
  }

  $current_user = NULL;
  return NULL;
}


/* Source: Code adapted from Kyle Harm's code in Lab8 */
function find_session($session_id) {

  /* We initially check if a session id has been set. If it has, we match this session id to the corresponding session record and then finally return the session record which should be unique. However, if there is no corresponding session, null is returned*/
  global $db;
  if (isset($session_id)) {
    $sql = "SELECT * FROM sessions WHERE session = :session;";
    $params = array(
      ':session' => $session_id
    );
    $records = exec_sql_query($db, $sql, $params)->fetchAll();
    if ($records) {
      return $records[0];
    }
  }
  return NULL;
}


/* Source: Code adapted from Kyle Harm's code in Lab8 */
function find_user($user_id) {
  /* Using the unique user id, this function finds the users record and returns it, if no user is found NULL is returned */
  global $db;
  $sql = "SELECT * FROM users WHERE id = :user_id;";
  $params = array(
    ':user_id' => $user_id
  );
  $user = exec_sql_query($db, $sql, $params)->fetchAll();
  if ($user) {
    return $user[0];
  }
  return NULL;
}


/* Source: Code adapted from Kyle Harm's code in Lab8 */
function session_login() {
  /* If a cookie has been set, the previous function using the cookie finds the user which matches the session id in the cookie and returns this users record. This function then amends the cookie's expiry time to thirty minutes into the future and then returns the user. If theres no user matching the session id both functions return null also if no cookie has been set, this function returns null.
   */
  global $current_user;
  if (isset($_COOKIE["session_name"])) {
    $session = $_COOKIE["session_name"];
    $session_record = find_session($session);
    if ( isset($session_record) ) {
      $current_user=find_user($session_record['user_id']);
      setcookie("session_name", $session, time()+1800);
    }

    return $current_user;
  }
  $current_user = NULL;
  return NULL;
}


/* Source: Code adapted from Kyle Harm's code in Lab8 */
function is_user_logged_in() {
  /* This function checks if a user is logged in by checking if the currentuser variable is null. if it is null, no user is logged on else a user is logged in
   */
  global $current_user;
  return (!is_null($current_user));
}


/* Source: Code adapted from Kyle Harm's code in Lab8 */
function log_out() {
  /*
  This function logs a user out, by setting a cookie's expiry time into the past by about 10,000 second, causing the cookie to be destroyed, after which the current user variable is set to null to show no user is logged in
  */
  global $current_user;
  setcookie("session_name", "", time()-10000);
  $current_user = NULL;
}

$sources=array("https://blog.nwf.org/2018/05/three-ways-to-take-action-for-monarch-butterflies/","https://wall.alphacoders.com/big.php?i=767527&lang=Turkish","http://wallpapersexpert.com/giraffe-wallpapers/3601836.html", "https://blog.nwf.org/2018/05/three-ways-to-take-action-for-monarch-butterflies/","https://wall.alphacoders.com/big.php?i=767527&lang=Turkish","http://wallpapersexpert.com/giraffe-wallpapers/3601836.html", "https://blog.nwf.org/2018/05/three-ways-to-take-action-for-monarch-butterflies/",
    "http://wallpapersexpert.com/giraffe-wallpapers/3601836.html",
    "https://wall.alphacoders.com/big.php?i=767527&lang=Turkish",
    "https://blog.nwf.org/2018/05/three-ways-to-take-action-for-monarch-butterflies/"
    );



function tags_output($id){
    global $db;
    $params = array(
        ':id'=>$id
    );
    $sql= "SELECT tag_name, image_tags.id FROM image_tags INNER JOIN tags ON tags.id=tag_id WHERE image_id=:id ";
    $output= exec_sql_query($db, $sql, $params);
    $tags_output =$output->fetchAll();
    if(is_user_logged_in()){
        foreach($tags_output as $tag_output){
            ?>
            <li>
                <form method="POST" action="images.php">
                    <fieldset>
                        <button type="submit" name="deletetag" value="<?php echo $tag_output["id"]?>" class="tagbtn">
                        <?php echo htmlspecialchars($tag_output["tag_name"])?> | X</button>
                    </fieldset>
                </form>
            </li>
            <?php
        }
    } else{
        foreach($tags_output as $tag_output){
            ?>
            <li class="taglogout">
                <button class="tagbtn">
                <?php echo htmlspecialchars($tag_output["tag_name"])?> </button>
            </li>
            <?php
        }
    }

    if(count($tags_output)==0){
        ?>
            <li class="notags">
                <button name="deletebutton" class="tagbtn"> No tags </button>
            </li>
        <?php
    }
}

function getextension($id){
  global $db;
  $params = array(
      ':id' => $id
  );
  $sql="SELECT * FROM images
  WHERE id=:id";
  $output= exec_sql_query($db, $sql, $params);
  $records =$output->fetchAll();
  return $records[0]["extension"];
}

function image_details($record){
    global $sources;

    ?>


    <div class="<?php if(is_user_logged_in()) {echo "imgRecord";} else {echo "imgRecordlogout";} ?>">

        <img src="uploads/images/<?php echo htmlspecialchars($record["id"]).".".htmlspecialchars($record["extension"]); ?>" class="scaleimg" alt="<?php echo htmlspecialchars($record["bio"]); ?>">
        <?php if($record["id"]<=10){ ?>
        <!-- Source: <?php echo $sources[$record["id"]-1];?> -->
        <a href="<?php  echo $sources[$record["id"]-1];?>" class="refer"> Source:
            <?php  echo $sources[$record["id"]-1];?>
        </a>

        <?php } ?>

        <h6> Tags <?php if(is_user_logged_in()){echo "(Click to delete)";}?></h6>

        <ul>
            <?php tags_output($record["id"]) ?>
        </ul>

        <div class="viewbutton">
            <p><a href="<?php echo 'animal.php?'.http_build_query(array('id'=>htmlspecialchars($record["id"]))) ?>">View</a></p>
        </div>

        <form method="post" action="images.php">
            <fieldset>
            <p>
                <label>Insert New Tag</label>
                <input type="text" class="newtag" name="insertnew">
            </p>

            <p>
                <label>Include Tag</label>
                <select name="includetag">
                    <option selected value="default"> -- select an option -- </option>
                    <?php
                    global $db;
                    $sql = "SELECT * FROM tags WHERE id NOT IN (SELECT tag_id FROM image_tags WHERE image_id=:id)";
                    $params = array(
                        ':id' => $record["id"]
                    );
                    $output= exec_sql_query($db, $sql, $params);
                    $existingtags = $output->fetchAll();
                    foreach($existingtags as $existingtag){
                    ?>
                        <option value="<?php echo htmlspecialchars($existingtag['id'])?>" ><?php echo htmlspecialchars($existingtag['tag_name'])?> </option>
                        <?php
                    }
                    ?>
                </select>
            </p>
            </fieldset>

            <button class="viewbutton" name="confirmchanges" value="<?php echo htmlspecialchars($record["id"])?>" type="submit">Confirm Changes</button>
        </form>

        <p> Bio: <?php echo htmlspecialchars($record["bio"]);?> </p>

        <?php if(is_user_logged_in()){


        ?>

        <div class="viewbutton">
          <p><a href="<?php echo 'animal.php?'.http_build_query(array('deletebutton'=>htmlspecialchars($record["id"]))) ?>">Delete</a></p>
        </div>

        <?php
        }
        ?>
    </div>

<?php
}
?>
