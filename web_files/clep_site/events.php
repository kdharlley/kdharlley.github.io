<?php
  include("includes/init.php");
  $title="LEP | Events";
  $now = date('Y-m-d h:s'); // YYYY-MM-DD HH-SS (24 hour time) format to be used in queries
  $messages = array();




  // DELETE EVENT
  if(isset($_GET['delete'])  && is_user_logged_in()){
    $db->beginTransaction();
    $id = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);

    $sql = "DELETE FROM events WHERE id = :id;";
    $params = array(
      ':id' => $id
    );
    exec_sql_query($db, $sql, $params);
    $sql = "DELETE FROM eboard_events WHERE event_id = :id;";
    $params = array(
      ':id' => $id
    );
    exec_sql_query($db, $sql, $params);
    $db->commit();
  }

  // DELETE MEMBER IN CHARGE OF EVENT
  if(isset($_GET['rem_rel'])  && is_user_logged_in()){
    $id = filter_input(INPUT_GET, 'rem_rel', FILTER_SANITIZE_NUMBER_INT);

    $sql = "DELETE FROM eboard_events WHERE id = :id;";
    $params = array(
      ':id' => $id
    );
    exec_sql_query($db, $sql, $params);
  }

  // ADD-EVENT FORM RESPONSIVENESS
  if( isset($_POST["addEvent"]) && is_user_logged_in() ){
    $add_event = TRUE;

    if(trim($_POST['event-name']) != ''){ //event name = required
      $name = filter_input(INPUT_POST, 'event-name', FILTER_SANITIZE_STRING);
    } else{
      array_push($messages, "A name for the event is required.");
      $name = NULL;
      $add_event = FALSE;
    }

    if(trim($_POST['location']) != ''){ //location = required
      $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
    } else{
      array_push($messages, "A location for the event is required.");
      $location = NULL;
      $add_event = FALSE;
    }

    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

    if(trim($_POST['event-date']) != ''){ //date = required
      if (filter_input(INPUT_POST, "event-date", FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/")))) {
        $date = filter_input(INPUT_POST, 'event-date', FILTER_SANITIZE_NUMBER_INT);
      } else {
        array_push($messages, "Invalid date format.");
        $date = NULL;
        $add_event = FALSE;
      }
    } else{
      array_push($messages, "Date is required.");
      $add_event = FALSE;
    }

    if($_POST['start-time'] != '--default--'){ //start time= required
      if (filter_input(INPUT_POST, "start-time", FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]{1,2}$/")))) {
        $startTime = filter_input(INPUT_POST, 'start-time', FILTER_SANITIZE_NUMBER_INT);
      } else {
        array_push($messages, "Invalid time for your event's starting time.");
        $startTime = NULL;
        $add_event = FALSE;
      }
    } else{
      array_push($messages, "Start time is required.");
      $add_event = FALSE;
    }

    //format time
    if(isset($startTime) && isset($date)){
      if($_POST['timeStart'] == 'PM'){
        $startTime += 12;
      }
      $start_datetime = $date . " " . $startTime . ":00:00";
    }

    if($_POST['end-time'] != '--default--'){ //end time = required
      if (filter_input(INPUT_POST, "end-time", FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]{1,2}$/")))) {
        //format end time
        $time = filter_input(INPUT_POST, 'end-time', FILTER_SANITIZE_NUMBER_INT);
        $timeEnd = filter_input(INPUT_POST, 'timeEnd', FILTER_SANITIZE_SPECIAL_CHARS);
        $end_time = $time . ":00 " . $_POST['timeEnd'];
      } else {
        array_push($messages, "Invalid time for your event's ending time.");
        $end_time = NULL;
        $add_event = FALSE;
      }
    } else{
      array_push($messages, "End time is required.");
      $add_event = FALSE;
    }

    //if all required fields were correctly entered add event
    if ($add_event) {

      $db->beginTransaction();
      //query for inserting a review into DB
      $sql = "INSERT INTO events('title','start_datetime','end_time','location', 'description') VALUES(:title, :start_datetime, :end_time, :location, :description);";
      $params = array(
        ':title' => $name,
        ':start_datetime' => $start_datetime,
        ':end_time' => $end_time,
        ':location' => $location,
        ':description' => $description
      );
      $result = exec_sql_query($db, $sql, $params);

      if ($result) { //if result was successful
        array_push($messages, "Your event has been added. Thank you!");
      } else {
        array_push($messages, "Failed to add event.");
      }

      $id_db=$db->lastInsertId();

      // add a board member in charge of event (seperate table!)
      if(isset($_POST['eboardsselected'])){

        $eboardsselected = array_filter($_POST['eboardsselected']);
        foreach($eboardsselected as $eboardselected){
          $eboardselected= filter_var($eboardselected, FILTER_SANITIZE_STRING);
          $sql = "INSERT INTO eboard_events(eboard_id, event_id) VALUES (:eboard_id, :event_id);";
          $params = array(
            ':eboard_id' => $eboardselected,
            ':event_id' => $id_db
          );
          $output = exec_sql_query($db, $sql, $params)->fetchAll();
        }
      }
      $db->commit();

      } else {
      array_push($messages, "Failed to add event. Invalid fields.");
    }
  }

    // QUERY PAST EVENTS
    $sql = "SELECT * FROM events WHERE start_datetime < :now;";
    $params = array(
      'now' => $now
    );
    $result = exec_sql_query($db, $sql, $params);
    if ($result) {
      $past = $result->fetchAll();
    } else {
      $past = FALSE;
    }

    // QUERY UPCOMING EVENTS
    $sql = "SELECT * FROM events WHERE start_datetime >= :now;";
    $params = array(
      'now' => $now
    );
    $result = exec_sql_query($db, $sql, $params);
    if ($result) {
      $upcoming = $result->fetchAll();
    } else {
      $upcoming = FALSE;
    }
  //PRINT EVENTS
  function display_events($events) {
    global $db;
    foreach ($events as $event) {
      // QUERY MEMBER IN CHARGE OF EVENT INFORMATION FROM eboard_events table
      $id = $event['id'];

      $params = array(
        ':event_id' => $id
      );
      $sql= "SELECT name, eboard_events.id AS id FROM eboard INNER JOIN eboard_events ON eboard_id= eboard.id WHERE event_id=:event_id";
      $output= exec_sql_query($db, $sql, $params);
      $rels_id = $output->fetchAll();

      echo "<div
        id='event-$id' class='event'> <h3 class='event-name'>" . date('l, F jS',htmlspecialchars(strtotime($event['start_datetime']))) . ": " . htmlspecialchars($event['title']) . "</h3>"; // e.g. Saturday, May 4th: Language Corner

        // SHOW EVENT DETAILS WHEN 'Details' IS PRESSED
        ?>
        <p class='show-event-details'><a  role='button'>Details</a></p>
      </div>

      <div class="event-details hidden"> <!-- EVENT DETAILS -->

        <?php
          // event details (time, location, description):
          echo "<p>" . date('g:i a',htmlspecialchars(strtotime($event['start_datetime']))) . " - " . date('g:i a',htmlspecialchars(strtotime($event['end_time']))) . " at " . htmlspecialchars($event['location']);
          echo "<p>" . htmlspecialchars($event['description']) . "</p>";

        //PRINT MEMBER IN CHARGE OF
        if (sizeof($rels_id)!=0){?>

          <p><strong> Members in charge of this event: </strong></p>

          <?php if (is_user_logged_in()){ echo "<p>Click [x] to remove a member</p>"; }?>
          <ul>
          <?php
            foreach($rels_id as $rel_id){
              if (is_user_logged_in()){
          ?>

                <li><p><?php echo htmlspecialchars($rel_id['name']) ?> [<a href="<?php echo 'events.php?'.http_build_query(array('rem_rel'=>htmlspecialchars($rel_id["id"]))) ?>">x</a>]</p></li>

              <?php
              } else {
                ?>
                <li><p><?php echo htmlspecialchars($rel_id['name']) ?></p></li>
                <?php
            }
          } ?>
          </ul>
        <?php } ?>
        <p class="show-less"><a role="button">Show Less</a></p>

      </div>

      <?php
      // allow logged in users to edit or delete individual events (similar to member.php page)
      if (is_user_logged_in()){?>
        <a class='button' href= "eventEdit.php?<?php echo http_build_query(array('edit' => $event['id'])) ;?>">Edit Details</a>
        <a class='button' href= "<?php echo htmlspecialchars(basename($_SERVER['PHP_SELF'])) . "?" .  http_build_query(array('delete' => $event['id'])) ;?>">Delete Event</a><br/>
        <?php
      }
      echo "<br/>";
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
    <div class="main">
      <?php include("includes/navigation_bar.php")?>
      <div class="right_side">
        <div class="main_content">
          <div id=eventResults>

            <h1>Upcoming Events</h1>

            <?php if ($upcoming==FALSE) {
              echo "<p>Please check back later for upcoming LEP events!</p>";

            } else {
              display_events($upcoming);
            }?>

            <h1>Past Events</h1>

            <?php if ($past==FALSE) {
              echo "<p>No past events to show at this time.</p>";

            } else {
              display_events($past);
            }
            ?>
          </div>

          <?php
          if (is_user_logged_in()){?>
            <hr>
            <p id="add-event"><a role="button">Add Event</a></p>

            <div id="addEvent" class="hidden">

              <h2>Add an Event</h2>
              <p id="message"> * Required</p>

              <?php
              // Write out any messages to the user.
              foreach ($messages as $message) {
                echo "<p><strong>" . htmlspecialchars($message) . "</strong></p>\n";
              }
              ?>

              <form id="eventForm" action="events.php" method="post">
                <ul>

                  <li>
                    <label for="event-name" id="name-label" class='asterisk'><strong>Name:</strong></label>
                    <input id="event-name" class="name_style" name="event-name">
                  </li>

                  <li>
                    <label for="event-date" class="below asterisk"><strong>Date: In format YYYY-MM-DD</strong></label>
                    <input id="event-date" name="event-date">
                    <p></p>
                  </li>

                  <?php

                  function print_times(){
                    ?>
                    <option value='default'>--default--</option>
                    <?php
                    for($i=1; $i <= 12; $i++){
                      echo "<option value='$i'>" . $i . ":00</option>";
                    }
                  }?>

                  <li>
                    <label for="start-time" class='asterisk replace'><strong>Start Time:</strong></label>
                    <select id="start-time" name="start-time" size="1">
                      <?php print_times(); ?>
                    </select>
                    <select id='timeStart' name='timeStart' size='1' class='asterisk'>
                      <option value='AM'>AM</option>
                      <option value='PM'>PM</option>
                    </select>
                  </li>

                  <li>
                    <label for="end-time" class='asterisk'><strong>End Time:</strong></label>
                    <select id="end-time" name="end-time" size="1">
                      <?php print_times(); ?>
                    </select>
                    <select id='timeEnd' name='timeEnd' size='1'>
                    <option value='AM'>AM</option>
                      <option value='PM'>PM</option>
                    </select>
                  </li>

                  <li>
                    <label for="location" class='asterisk'><strong>Location:</strong></label>
                    <input id="location" name="location">
                  </li>

                  <li>
                    <label for="description" class="below"><strong>Description:</strong></label>
                    <textarea id='description' name="description" rows="5" cols="60"></textarea>
                  </li>

                  <li>
                    <label class="below asterisk"> <strong>In-Charge:</strong> </label>
                    <div>(to select multiple executives in charge hold cmd and click)</div>
                    <select multiple name="eboardsselected[]">
                      <?php

                        $params = array();
                        $sql="SELECT * FROM eboard";
                        $output= exec_sql_query($db, $sql, $params);
                        $eboards = $output->fetchAll();

                        function output_eboard($eboard){
                          ?>
                          <option value=<?php echo htmlspecialchars($eboard["id"])?>> <?php echo htmlspecialchars($eboard["name"]) ?></option>
                          <?php
                        }

                        foreach($eboards as $eboard){
                          output_eboard($eboard);
                        }
                      ?>
                    </select>
                  </li>

                  <li>
                    <button name="addEvent" type="submit" id="event_submit"><strong>Add Event</strong></button>
                  </li>

                </ul>
              </form>
              <p id="hide-form"><a role="button">Show Less</a></p>
            </div>

          <?php } ?>
        </div>
      </div>
    </div>
  </div>

  <?php include("includes/footer.php");?>

  <script src="scripts/jquery-3.2.1.min.js"></script>
  <script src="scripts/event.js"></script>
</body>
</html>
