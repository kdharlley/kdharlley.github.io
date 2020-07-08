<?php
  include("includes/init.php");
  $title="LEP | Join Us";
  $fullname="";
  $email="";
  $class='';
  $speak='';
  $practice='';
  $position="";
  $full_name="";
  $netid='';
  $graduation='';
  $college='';
  $major='';
  $phone='';
  $languages='';
  $credits='';
  $other_activities='';
  $why='';
  $what_skills='';
  $time_commitments='';
  $time_management='';
  $practice1='';
  $messages=array();
  $eboardMessages=array();

  // was the form submitted
  if ( isset($_POST["submit"]) ) {
    $valid_entry1 = TRUE;

    $fullname= filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_STRING);
    $class = filter_input(INPUT_POST, 'class', FILTER_VALIDATE_INT);
    $speak= filter_input(INPUT_POST, 'speak', FILTER_SANITIZE_STRING);
    $practice1 = filter_input(INPUT_POST, 'practice1', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    // name is required
    if ($fullname==NULL){
      $valid_entry1 = FALSE;
      array_push($messages,"Please enter your full name");
    }

    if($class==NULL){
      $valid_entry1=FALSE;
      array_push($messages,"Please enter your graduation year");
    }

    if($speak==NULL){
      $valid_entry1=FALSE;
      array_push($messages,"Please enter the languages you currently speak");
    }

    if($practice1==NULL){
      $valid_entry1=FALSE;
      array_push($messages,"Please enter the languages you want to practice");
    }

    if($email==NULL){
      $valid_entry1=FALSE;
      array_push($messages,"Please enter your email address");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $valid_entry1=FALSE;
      array_push($messages,"Please enter a valid email address");
    }
    // now we add the inputted information to the database
    if ($valid_entry1) {
      $sql = "INSERT INTO listerv (fullname, class, speak, practice) VALUES (:fullname, :class, :speak, :practice1)";
      $params = array(
        ':fullname' => $fullname,
        ':class' => $class,
        ':speak' => $speak,
        ':practice1' => $practice1
      );
      $results = exec_sql_query($db, $sql, $params);
      array_push($messages,"Thank you! Your entries have been recorded :)");
    }
  }

  function print_record_positions($title) {
    global $db;

    echo "<div class='event'> <p class='show-event-details'><a  role='button'>Details</a></p></div>";

    $sql ="SELECT responsibilities.responsibility FROM positions INNER JOIN responsibilities ON positions.id = responsibilities.position_id WHERE positions.title = :position;";
    $params = array(
      ':position'=>$title
    );
    $records = exec_sql_query($db, $sql, $params)->fetchAll();

    if ($records) {
      echo "<div class='hidden'><ul>";
      foreach ($records as $responsibility) {
        echo "<li>" . htmlspecialchars($responsibility["responsibility"]) . "</li>";
      }
      echo "</ul><p class='show-less'><a role='button'>Show Less</a></p>";
      echo "</div>";
    }
  }

  if ( isset($_POST["submit_insert"]) ) {
    $valid_entry = TRUE;

    // both fields required
    if (trim($_POST['title']) == ""){
      $valid_entry = FALSE;
      array_push($eboardMessages, "Title of position is required.");
    }else{
      $title= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
      // check if title of role already exists
      $sql = "SELECT title FROM positions;";
      $params = array();
      $titles = exec_sql_query($db, $sql, $params)->fetchAll();
      foreach($titles as $titleOG){
        if($titleOG == $title){
          $valid_entry = FALSE;
          array_push($eboardMessages, "This position is already added.");
        }
      }
    }

    if (trim($_POST['description']) == "") {
      $valid_entry = FALSE;
      array_push($eboardMessages, "Please add at least one responsibility.");
    }else{
      $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    }


    // now we add the inputted information to the database
    if ($valid_entry) {
      $sql = "INSERT INTO positions (title) VALUES (:title)";
      $params = array(
        ':title' => $title
      );
      exec_sql_query($db, $sql, $params);
      $responsibilities = explode("\n", $description); //creates array
      $id = $db->lastInsertId("id");
      foreach($responsibilities as $responsibility){
        if($responsibility != ""){
          $sql = "INSERT INTO responsibilities (position_id, responsibility) VALUES (:position_id, :responsibility)";
          $params = array(
            ':position_id' => $id,
            ':responsibility' => $responsibility
          );
          exec_sql_query($db, $sql, $params);
        }
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css"/>
  <title><?php echo $title; ?></title>
</head>

<body>
  <div>
    <?php include("includes/header.php")?>
    <div class='main'>
      <?php include("includes/navigation_bar.php")?>
      <div class="right_side">
        <div class="main_content">

          <h1>Join our listserv!</h1>

          <p id="message"> * Required</p>
          <?php
          foreach ($messages as $message) {
            echo "<p id='message'>".htmlspecialchars($message)."</p>\n";
          }?>

          <form id="JoinUs" action="join.php" method="post">
            <ul>

              <li>
                <label for="fullname" class="asterisk"><strong>Full Name:</strong></label>
                <input id="fullname" type="text" name="fullname" value="<?php echo htmlspecialchars($fullname)?>"/>
              </li>

              <li>
                <label for="email" class="asterisk"><strong>Email:</strong></label>
                <input id="email" type="text" name="email" value="<?php echo htmlspecialchars($email)?>"/>
              </li>

              <li>
                <label for="class" class="asterisk"><strong>Year of Graduation:</strong></label>
                <input id="class" type="text" name="class" value="<?php echo htmlspecialchars($class)?>" />
              </li>

              <li>
                <label for="speak" class="asterisk"><strong>Languages you can speak:</strong></label>
                <input id="speak" type="text" name="speak" value="<?php echo htmlspecialchars($speak)?>" />
              </li>

              <li>
                <label for="practice1" class="asterisk"><strong>Languages you want to practice:</strong></label>
                <input id="practice1" type="text" name="practice1" value="<?php echo htmlspecialchars($practice1)?>"/>
              </li>

              <li>
                <button name="submit" type="submit" id="join_button" ><strong>Submit</strong></button>
              </li>

            </ul>
          </form>

          <?php
          $sql="SELECT * FROM listerv";
          $results=exec_sql_query($db,$sql,array())->fetchAll(PDO::FETCH_ASSOC);

          if (is_user_logged_in()){
            ?>
            <h3> For E-board use: </h3>
            <p><a href="listervapps.php" class="button">View Listserv Requests</a></p>
          <?php } ?>

          <h1><br/>Join the LEP Executive Board!</h1>

          <h2><br/>Program Description</h2>

          <p> The Cornell Public Service Center's (PSC) Language Expansion Program (LEP) is a student-led program that fosters language learning in a comfortable, encouraging environment for its participants. LEP provides a unique opportunity for individuals to pursue their interest in language learning. We host the weekly Language Corner where language learners can practice their target language(s) and exchange cultural knowledge. </p>

          <h2><br/>Executive Board Member Expectations</h2>

          <p>E-Board members are required to attend the weekly LEP board meeting, every Monday at 4:30pm. LEP E-Board members are also expected to hold at least one 1 office hour per week, and assist in club events. </p>

          <h2><br/>Open positions </h2>

          <?php // this here is going to display the database of available eboard positions
          // this code is based on lab 6 code

            $pos = exec_sql_query($db, "SELECT * FROM positions", array())->fetchAll(PDO::FETCH_ASSOC);
            foreach($pos as $p_record) {
              ?><div class='open_position'>
                <h3><strong><?php echo htmlspecialchars($p_record['title']);?></strong></h3>

                <?php print_record_positions(htmlspecialchars($p_record['title']));?>

              </div><?php
            }
          ?>

      <p>If you're interested in becoming an eboard member, please<a href="appform.php" class="link"><strong>fill out an application!</strong></a></p>

      <?php
        if (is_user_logged_in()) {
          ?>
          <h3> <br/>For E-board use: </h3>
          <form id="add_position" action="join.php" method="post">
            <ul>
              <li>Update the list with available e-board positions:</li>
              <?php
              foreach ($eboardMessages as $eboardMessage) {
              echo "<p id='message'>".htmlspecialchars($eboardMessage)."</p>\n";
              }?>
              <li>
                <label for="title" class="asterisk"><strong>Name of position: </strong></label>
                <input id="title" type="text" name="title" /><br/><br/>
              </li>
              <li>
                <label for="description" id="below" class="asterisk"><strong>Responsibilities:</strong></label>
                <textarea id='description' name="description" rows="5" cols="60"></textarea>
              </li>
              <li>
                <button name="submit_insert" type="submit" id="position_button"><strong>Submit</strong></button>
              </li>
            </ul>
          </form>

          <p>
            <a href="ebapps.php" class="button">View Applications</a>
            <a href="delete_position.php" class="button">Delete Positions</a>
          </p>
        <?php } ?>

        </div>
      </div>
    </div>
  </div>

  <?php include("includes/footer.php")?>

  <script src="scripts/jquery-3.2.1.min.js"></script>
  <script src="scripts/event.js"></script>

</body>
</html>
