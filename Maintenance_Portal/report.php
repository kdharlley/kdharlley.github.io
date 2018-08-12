<?php
// connection to databases and creation of variables

session_start();

$hostname = 'localhost';

$dbusername = 'dharlley';

$dbpassword = 'dharlley';

$msg = ''; 

$link = mysqli_connect($hostname,$dbusername,$dbpassword)  or die("failed to connect to server !!");
mysqli_select_db($link,"dbmaintenance");

// checking access level
 if($_SESSION["access_level"]=="admin"){

//creation of variables
$description = $_POST['descriptionwrk'];
$location = $_POST['locationtext'];
$comments = $_POST['commentss'];
$dtcomp = $_POST['djc'];
$dtsupply = $_POST['dosm'];
$dtcommenc = $_POST['docw'];
$dtreceiv = $_POST['dra'];
$dtrequest = $_POST['dorm'];
$dtmaint = date('Y-m-d H:i:s');
$jobarea = $_POST['jobrad'];
$jobstate =$_POST['jobstate'];
$facilityid =$_POST['selfacility'];
$userid = $_SESSION['user_id'];
$user_firstname = $_SESSION['first_name'];
$user_lastname= $_SESSION['last_name'];

//inserting data into database

$uploadjob = "INSERT INTO maintenance_job (dr_maint, dr_artisan, dr_materials, ds_materials, dc_job, location, description, job_state, user_id, job_area, facility_id, user_firstname, user_lastname, dt_commenc, comments)
 VALUES ('$dtmaint', '$dtreceiv' , '$dtrequest', '$dtsupply', '$dtcomp', '$location', '$description','$jobstate', '$userid', '$jobarea', '$facilityid', '$user_firstname','$user_lastname', '$dtcommenc','$comments')";


//  Checking if job created successfully
if ($link->query($uploadjob) == TRUE) {
	?>
	<script type="text/javascript">
	alert('New Maintenance Job created successfully');
	window.location = 'homepage.php';
	</script>
	<?php
} else {
    	?>
	<script type="text/javascript">
	alert('There was a problem uploading the job');
	window.location = 'homepage.php';
	</script>
	<?php
}

}

//checking if access level user
 if($_SESSION["access_level"]=="user"){

//creation of variables
$description = $_POST['descriptionwrk'];
$location = $_POST['locationtext'];
$comments = $_POST['commentss'];
$dtmaint = date('Y-m-d H:i:s');
$jobarea = $_POST['jobrad'];
$jobstate =$_POST['jobstate'];
$facilityid =$_POST['selfacility'];
$userid = $_SESSION['user_id'];
$user_firstname = $_SESSION['first_name'];
$user_lastname= $_SESSION['last_name'];

//SQL to insert into database
$uploadjob = "INSERT INTO maintenance_job (dr_maint, location, description, job_state, user_id, job_area, facility_id, user_firstname, user_lastname, comments)
 VALUES ('$dtmaint', '$location', '$description','$jobstate', '$userid', '$jobarea', '$facilityid', '$user_firstname','$user_lastname','$comments')";

//checking if data inputted into database successfully
if ($link->query($uploadjob) == TRUE) {
	?>
	<script type="text/javascript">
	alert('New Maintenance Job created successfully');
	window.location = 'homepage.php';
	</script>
	<?php
} else {

        	?>

	<script type="text/javascript">
	alert('There was a problem uploading the job');
	window.location = 'homepage.php';

	<?php

}
}
?>