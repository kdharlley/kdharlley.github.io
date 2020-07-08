<?php
  include("includes/init.php");
  $title="LEP | E-board Application";
  $fullname="";
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
  $applications=array();

  const MAX_FILE_SIZE = 1000000;

  // if form was submitted
  if ( isset($_POST["submit2"]) ) {

    $valid_entry3= TRUE;
    $position= filter_input(INPUT_POST, 'position', FILTER_SANITIZE_STRING);
    $full_name = filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_STRING);
    $netid= filter_input(INPUT_POST, 'netid', FILTER_SANITIZE_STRING);
    $graduation = filter_input(INPUT_POST, 'graduation', FILTER_SANITIZE_STRING);
    $college= filter_input(INPUT_POST, 'college', FILTER_SANITIZE_STRING);
    $major = filter_input(INPUT_POST, 'major', FILTER_SANITIZE_STRING);
    $phone= filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $languages = filter_input(INPUT_POST, 'languages', FILTER_SANITIZE_STRING);
    $credits= filter_input(INPUT_POST, 'credits', FILTER_SANITIZE_STRING);
    $other_activities = filter_input(INPUT_POST, 'other_activities', FILTER_SANITIZE_STRING);
    $why= filter_input(INPUT_POST, 'why', FILTER_SANITIZE_STRING);
    $what_skills = filter_input(INPUT_POST, 'what_skills', FILTER_SANITIZE_STRING);
    $time_commitments= filter_input(INPUT_POST, 'time_commitments', FILTER_SANITIZE_STRING);
    $time_management = filter_input(INPUT_POST, 'time_management', FILTER_SANITIZE_STRING);
    $upload_info = $_FILES["resume"];

    if ($position==NULL){
        $valid_entry3=FALSE;
        array_push($applications,"Please enter a valid position");
    }

    if ($full_name==NULL){
      $valid_entry3=FALSE;
      array_push($applications,"Please enter your full name");
    }

    if ($netid==NULL){
      $valid_entry3=FALSE;
      array_push($applications,"Please enter a valid NetID");
    }

    if ($graduation==NULL){
      $valid_entry3=FALSE;
      array_push($applications,"Please enter a valid graduation year");
    }

    if ($college==NULL){
      $valid_entry3=FALSE;
      array_push($applications,"Please enter a valid college");
    }

    if ($major==NULL){
      $valid_entry3=FALSE;
      array_push($applications,"Please enter a valid major");
    }

    if ($phone==NULL){
      $valid_entry3=FALSE;
      array_push($applications,"the phone cannot be empty");
    }

    if ($languages==NULL){
      $valid_entry3=FALSE;
      array_push($applications,"Please enter a valid language");
    }

    if ($why==NULL){
      $valid_entry3=FALSE;
      array_push($applications,"Please enter why you are interested in an executive board position");
    }

    if ($what_skills==NULL){
      $valid_entry3=FALSE;
      array_push($applications,"Please enter your relevant skills for the position");
    }

    if ($time_commitments==NULL){
      $valid_entry3=FALSE;
      array_push($applications,"Please enter your other time commitments");
    }

    if ($time_management==NULL){
      $valid_entry3=FALSE;
      array_push($applications,"Please enter your plans regarding time management");
    }

    // add the inputted information to the database
    if (($valid_entry3) && ( $upload_info['error'] == UPLOAD_ERR_OK )) {

      // Get the name of the uploaded file without any path
      $upload_name = basename($upload_info["name"]);

      // Get the file extension of the uploaded file
      $upload_ext = strtolower( pathinfo($upload_name, PATHINFO_EXTENSION) );

      $sql = "INSERT INTO applications (position, full_name, netid, graduation, college, major, phone, languages, credits, other_activities, why, what_skills, time_commitments, time_management, file_name, file_ext) VALUES (:position, :full_name, :netid, :graduation, :college, :major, :phone, :languages, :credits, :other_activities, :why, :what_skills, :time_commitments, :time_management, :filename, :extension)";

      $params = array(
        ':position' => $position,
        ':full_name' => $full_name,
        ':netid' => $netid,
        ':graduation' => $graduation,
        ':college' => $college,
        ':major' => $major,
        ':phone' => $phone,
        ':languages' => $languages,
        ':credits' => $credits,
        ':other_activities' => $other_activities,
        ':why' => $why,
        ':what_skills' => $what_skills,
        'time_commitments' => $time_commitments,
        ':time_management' => $time_management,
        ':filename' => $upload_name,
        ':extension' => $upload_ext
      );

      $result = exec_sql_query($db, $sql, $params);
      array_push($applications,"Thank you! Your entries have been recorded :)");

      if ($result) {
          $file_id = $db->lastInsertId("file_name");
          $id_filename = 'uploads/resumes/' . $file_id . '.' . $upload_ext;
          move_uploaded_file( $upload_info["tmp_name"], $id_filename );
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

              <?php foreach ($applications as $application) {
                echo "<p id='message'>".htmlspecialchars($application)."</p> \n";
              }?>

              <h2> Executive Board Application Form </h2>

              <p id="message"> * Required</p>

                <form id="Apply" action="appform.php" method="post" enctype="multipart/form-data">
                    <ul>

                      <li>
                          <label for="position" class="asterisk"><strong>Which position would you like to apply for?</strong></label>
                          <input id="position" type="text" name="position" value="<?php echo htmlspecialchars($position)?>" />
                      </li>

                      <li>
                          <label for="full_name" class="asterisk"><strong>Full Name:</strong></label>
                          <input id="full_name" type="text" name="full_name" value="<?php echo htmlspecialchars($full_name)?>" />
                      </li>

                      <li>
                          <label for="netid" class='asterisk'><strong>NetID:</strong></label>
                          <input id="netid" type="text" name="netid" value="<?php echo htmlspecialchars($netid)?>"/>
                      </li>

                      <li>
                          <label for="graduation" class='asterisk'> <strong>Expected Graduation Month and Year:</strong></label>
                          <input id="graduation" type="text" name="graduation" value="<?php echo htmlspecialchars($graduation)?>"/>
                      </li>

                      <li>
                          <label for="college" class='asterisk'><strong>College (e.g. Engineering):</strong></label>
                          <input id="college" type="text" name="college" value="<?php echo htmlspecialchars($college)?>" />
                      </li>

                      <li>
                          <label for="major" class='asterisk'> <strong>Major(s) and Minor(s):</strong></label>
                          <input id="major" type="text" name="major" value="<?php echo htmlspecialchars($major)?>"/>
                      </li>

                      <li>
                          <label for="phone" class='asterisk'><strong>Phone Number:</strong></label>
                          <input id="phone" type="text" name="phone" value="<?php echo htmlspecialchars($phone)?>" />
                      </li>

                      <li> <!-- chagned to "Credits currently taken" from "Credits for Spring 2019" to increase ease of use in the future -->
                          <label for="credits"><strong>Credits currently enrolled in (e.g. 15):</strong></label>
                          <input id="credits" type="text" name="credits" value="<?php echo htmlspecialchars($credits)?>" />
                      </li>

                      <li>
                          <label for="languages" class="below asterisk"><strong> Language(s) Spoken (other than English):</strong></label>
                          <textarea id='languages' name="languages" rows="5" cols="60"><?php echo htmlspecialchars($languages)?></textarea>
                      </li>

                      <li>
                          <label for="other_activities" class="below"><strong>Please list all your on-campus and off-campus involvement during academic year, along with the estimated weekly time commitment. (Include volunteer activities, clubs, or other organizations on campus):</strong></label>
                          <textarea id='other_activities' name="other_activities" rows="5" cols="60" ><?php echo htmlspecialchars($other_activities)?></textarea>
                      </li>

                      <li>
                          <label for="why" class="below asterisk"><strong> Why are you interested in the board position you are applying? Explain your understanding of the responsibilities of the position you are applying for and why you believe you are qualified.</strong></label>
                          <textarea id='why' name="why" rows="5" cols="60" ><?php echo htmlspecialchars($why)?></textarea>
                      </li>

                      <li>
                          <label for="what_skills" class="below asterisk"> <strong>What skills do you possess that are specifically relevant to the position you are applying for?</strong></label>
                          <textarea id='what_skills' name="what_skills" rows="5" cols="60" ><?php echo htmlspecialchars($what_skills)?></textarea>
                      </li>

                      <li>
                          <label for="time_commitments" class="below asterisk"><strong>Please list your other anticipated significant time commitments for next year (approximate credit hours, other campus program involvements, on-campus or off-campus jobs, etc.). Do you plan to study abroad? If so, when?</strong></label>
                          <textarea id='time_commitments' name="time_commitments" rows="5" cols="60" ><?php echo htmlspecialchars($time_commitments)?></textarea>
                      </li>

                      <li>
                          <label for="time_management" class="below asterisk"> <strong>Based on your answers in the previous question, how do you plan to manage your time to ensure the completion of your LEP tasks?</strong></label>
                          <textarea id='time_management' name="time_management" rows="5" cols="60" ><?php echo htmlspecialchars($time_management)?></textarea>
                      </li>

                      <li>
                          <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />

                          <label for="resume" class="asterisk"><strong>Upload your resume here:</strong></label>
                          <input id="resume" type="file" name="resume">
                      </li>

                      <li>
                        <button name="submit2" type="submit" id="appform_button"><strong>Submit</strong></button>
                      </li>

                    </ul>
                </form>

                <a class="button right" href="join.php">Back to Join Us Page</a>
          </div>
        </div>
      </div>
    </div>

  <?php include("includes/footer.php")?>

</body>
</html>
