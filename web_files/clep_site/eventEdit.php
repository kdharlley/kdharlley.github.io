<?php
  include("includes/init.php");
  $title="LEP | Edit Event";

  //get information
  if($_GET['edit']){ // && is_user_logged_in()
    $id = filter_input(INPUT_GET, "edit", FILTER_SANITIZE_STRING);
    $sql = "SELECT * FROM events WHERE id = :id";
    $params = array(
        ':id' => $id
    );
    $result = exec_sql_query($db, $sql, $params);
    if($result){
      $events = $result->fetchAll();
      if(count($events) > 0) {
        $event = $events[0];
        $starting = $event['start_datetime'];
        $startingTime = substr($starting, -8, 2);
        if($startingTime > 12){
          $PM = TRUE;
          $startingTime -= 12;
        }
      }
    }
  }

  //update edits
  if(isset($_POST['edit-form'])){ //if edit form is submitted
    $edit_event = TRUE;

    if($_POST['event-name'] != ''){ //event name = required
      $name = filter_input(INPUT_POST, 'event-name', FILTER_SANITIZE_STRING);
    }else{
      array_push($messages, "A name for the event is required.");
      $edit_event = FALSE;
    }

    if($_POST['location'] != ''){ //location = required
      $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
    }else{
      array_push($messages, "A location for the event is required.");
      $edit_event = FALSE;
    }
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

    if($_POST['event-date'] != ''){
      if (filter_input(INPUT_POST, "event-date", FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]{4}\-[0-9]{2}\-[0-9]{2} [0-2]{1}[0-9]{1}:[0-6]{1}[0-9]{1}:[0-6]{1}[0-9]{1}$/")))) {
        $date = filter_input(INPUT_POST, 'event-date', FILTER_SANITIZE_SPECIAL_CHARS);
      } else {
        array_push($messages, "Invalid date format.");
        $edit_event = FALSE;
      }
    }else{
      array_push($messages, "Date is required.");
      $edit_event = FALSE;
    }


    if($_POST['end-time'] != ""){
      if (filter_input(INPUT_POST, "end-time", FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]{1,2}:[0-6]{1}[0-9]{1} [A,P]{1}M$/")))) {
        $time = filter_input(INPUT_POST, 'end-time', FILTER_SANITIZE_NUMBER_INT);
        $timeEnd = filter_input(INPUT_POST, 'timeEnd', FILTER_SANITIZE_SPECIAL_CHARS);
        $end_time = $time . ":00 " . $_POST['timeEnd'];
      } else {
        array_push($messages, "Invalid time for your event's ending time.");
        $edit_event = FALSE;
      }
    }else{
      array_push($messages, "End time is required.");
      $edit_event = FALSE;
    }

    //add event
    if ($edit_event) {
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
      if ($result) {
        array_push($messages, "Your event has been added. Thank you!");
      } else {
        array_push($messages, "Failed to edit event.");
      }
      } else {
      array_push($messages, "Failed to edit event. Invalid fields.");
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

          <?php if(isset($edit_event) && $edit_event){ ?>
            <p>You have successfully edited your event.</p>
            <p>Click <a href='events.php'>here</a> to go back and view all events.</p>
          <?php }?>

          <h2 id="edit_event">Edit Event</h2>

          <form id="edit-form" action="events.php">
            <ul>

              <li>
                <label for="event-name" id="name-label" ><strong>Name:</strong></label>
                <input id="event-name" name="event-name" value="<?php echo htmlspecialchars($event['title']); ?>">
              </li>

              <li>
                <label for="event-date" class="below"><strong>Date: In format YYYY-MM-DD HH:MM:SS (24 hour time - military time)</strong></label>
                <input id="event-date" name="event-date" value="<?php echo htmlspecialchars($event['start_datetime']); ?>">
                <p></p>
              </li>

              <li>
                <label for="end-time" class="below"><strong>End Time:</strong><br> Must be in format H:MM AM or PM. (Example: 6:00 PM) *Doesn't have to be in military time. </label>
                <input id="end-time" name="end-time" value="<?php echo htmlspecialchars($event['end_time']); ?>">
              </li>

              <li>
                <label for="location"><strong>Location:</strong></label>
                <input id="location" name="location" value="<?php echo htmlspecialchars($event['location']); ?>">
              </li>

              <li>
                <label for="description" class="below"><strong>Description:</strong></label>
                <textarea id='description' name="description" rows="5" cols="60"><?php echo htmlspecialchars($event['description']); ?></textarea>
              </li>

              <li>
                <button name="addEvent" type="submit" id="edit_form">Save Changes</button>
              </li>

            </ul>
          </form>
          <a class="button right" href="events.php">Back to Events Page</a>
        </div>
      </div>
    </div>
  </div>

  <?php include("includes/footer.php")?>

</body>
</html>
