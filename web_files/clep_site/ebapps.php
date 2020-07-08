<?php
  include("includes/init.php");
  $title = "LEP | View Applications";

  // print each E-Board application
  function print_record_app($record){
    ?>
    <div class="open_position">

      <p><strong> Application of <?php echo htmlspecialchars($record["full_name"]);?> </strong>

      <a class="button" href="<?php echo 'ebapps.php?'. http_build_query(array('delete'=>htmlspecialchars($record["id"]), 'id'=>htmlspecialchars($record["id"]))) ?>">Delete</a></p>

      <div class='event'> <p class='show-event-details'><a  role='button'>Details</a></p></div>
        <div class="hidden">

          <p><strong>Position</strong><br/>
          <?php echo htmlspecialchars($record["position"]);?></p>

          <p><strong>Name</strong><br/>
          <?php echo htmlspecialchars($record["full_name"]);?></p>

          <p><strong>NetID</strong><br/>
          <?php echo htmlspecialchars($record["netid"]);?></p>

          <p><strong>Graduation Year</strong><br/>
          <?php echo htmlspecialchars($record["graduation"]);?></p>

          <p><strong>College</strong><br/>
          <?php echo htmlspecialchars($record["college"]);?></p>

          <p><strong>Major</strong><br/>
          <?php echo htmlspecialchars($record["major"]);?></p>

          <p><strong>Phone</strong><br/>
          <?php echo htmlspecialchars($record["phone"]);?></p>

          <p><strong>Languages Spoken</strong><br/>
          <?php echo htmlspecialchars($record["languages"]);?></p>

          <p><strong>Credits Enrolled In</strong><br/>
          <?php echo htmlspecialchars($record["credits"]);?></p>

          <p><strong>Other Activities</strong><br/>
          <?php echo htmlspecialchars($record["other_activities"]);?></p>

          <p><strong>Why this applicant is interested in joining the e-board?</strong><br/>
          <?php echo htmlspecialchars($record["why"]);?></p>

          <p><strong>What pertinent skills does this applicant have?</strong><br/>
          <?php echo htmlspecialchars($record["what_skills"]);?></p>

          <p><strong>What are other time commitments that the applicant has?</strong><br/>
          <?php echo htmlspecialchars($record["time_commitments"]);?></p>

          <p><strong>How does the applicant plan to manage all of these time commitments?</strong><br/>
          <?php echo htmlspecialchars($record["time_management"]);?></p>

          <p><strong>Resume:</strong><br/>
          <a href="uploads/resumes/<?php echo htmlspecialchars($record["id"]) ?>.<?php echo htmlspecialchars($record["file_ext"]) ?> " class="button">View Resume</a>

          <p class='show-less'><a role='button'>Show Less</a></p>
        </div>
      </div> <br/>
    <?php }

  if (isset($_GET["delete"])){
    $value=filter_input(INPUT_GET, "delete", FILTER_SANITIZE_NUMBER_INT);
    $params = array(
        ':appid' => $value
    );
    $sql="DELETE FROM applications WHERE id=:appid";
    $output= exec_sql_query($db, $sql, $params);
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

          <h2> All E-Board Applications </h2>

          <?php
          $db->beginTransaction(); // transaction required since some of the steps rely on previous ones executing properly

          $sql="SELECT * FROM applications";
          $results=exec_sql_query($db,$sql,array())->fetchAll(PDO::FETCH_ASSOC);

          foreach($results as $result) {
              print_record_app($result);
          }

          $db->commit();

          ?>
          <a class="button right" href="join.php">Back to Join Us Page</a>

        </div>
      </div>
    </div>
  </div>

  <?php include("includes/footer.php")?>

  <script src="scripts/jquery-3.2.1.min.js"></script>
  <script src="scripts/ebapps.js"></script>

</body>
</html>
