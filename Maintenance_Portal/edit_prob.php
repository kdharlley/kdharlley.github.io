<?php
//connecting to database
session_start();

$hostname = 'localhost';

$dbusername = 'dharlley';

$dbpassword = 'dharlley';

$msg = ''; 

$link = mysqli_connect($hostname,$dbusername,$dbpassword)  or die("failed to connect to server !!");
mysqli_select_db($link,"dbmaintenance");

//checking access level
if($_SESSION["access_level"]=="admin"){

	//setting variables
	$description = $_POST['descriptionwrk'];
	$location = $_POST['locationtext'];
	$comments = $_POST['commentss'];
	$dtcomp = $_POST['djc'];
	$dtsupply = $_POST['dosm'];
	$dtcommenc = $_POST['docw'];
	$dtreceiv = $_POST['dra'];
	$dtrequest = $_POST['dorm'];
	$dtmaint = $_POST['dtmaint'];
	$jobarea = $_POST['jobrad'];
	$jobstate =$_POST['jobstate'];
	$facilityid =$_POST['selfacility'];
	$userid = $_SESSION['user_id'];
	$user_firstname = $_SESSION['first_name'];
	$user_lastname= $_SESSION['last_name'];
	$work_order=$_SESSION['work_order'];

	//SQL for updating records
	$editjob = "UPDATE maintenance_job SET dr_maint= '$dtmaint', dr_artisan='$dtreceiv', dr_materials='$dtrequest', ds_materials='$dtsupply', dc_job='$dtcomp', location='$location', description='$description', job_state='$jobstate', user_id='$userid', job_area='$jobarea', facility_id='$facilityid', user_firstname='$user_firstname', user_lastname='$user_lastname', dt_commenc='$dtcommenc', comments='$comments' WHERE work_order='$work_order'";

}

if($_SESSION["access_level"]=="user"){

	//setting variables
	$description = $_POST['descriptionwrk'];
	$location = $_POST['locationtext'];
	$comments = $_POST['commentss'];

	$jobarea = $_POST['jobrad'];
	$jobstate =$_POST['jobstate'];
	$facilityid =$_POST['selfacility'];
	$userid = $_SESSION['user_id'];
	$user_firstname = $_SESSION['first_name'];
	$user_lastname= $_SESSION['last_name'];
	$work_order=$_SESSION['work_order'];

	//SQL for updating records
	$editjob = "UPDATE maintenance_job SET location='$location', description='$description', job_state='$jobstate', user_id='$userid', job_area='$jobarea', facility_id='$facilityid', user_firstname='$user_firstname', user_lastname='$user_lastname', comments='$comments' WHERE work_order='$work_order'";

}





//checking if record updated successfully, giving suitable error messages
if ($link->query($editjob) === TRUE) {
		?>
	<script>
	alert('Record successfully updated');
	window.location = 'homepage.php';
	</script>
	<?php
} else {
	?>
	<script>
	alert('There were problems updating record thus record wasnt updated');
	window.location = 'homepage.php';
	</script>
	<?php
    echo "Error: " . $sql . "<br>" . $link->error;
}

?>