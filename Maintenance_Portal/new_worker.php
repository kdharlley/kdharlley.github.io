<?php
//connecting to database 
$link = mysqli_connect("localhost","dharlley","dharlley")  or die("failed to connect to server !!");
mysqli_select_db($link,"dbmaintenance");

//setting variables
$inputfirst = $_POST['firstname'];

$inputlast = $_POST['lastname'];

$telephone = $_POST['telephonenum'];

$inputworkm = $_POST['workman'];

 
//SQL for inserting into database
$registerwork = "INSERT INTO facility ( first_name_workman, last_name_workman, telephone, workman)
 VALUES ( '$inputfirst' , '$inputlast', '$telephone','$inputworkm')";


if ($link->query($registerwork) === TRUE) {
	//alert for successful user creation
	?>
	<script type="text/javascript">
	alert('New worker successfully created');
	window.location = 'homepage.php';
	</script>
	<?php
} else {
	//alert for error
	?>
	<script type="text/javascript">
	alert('New worker could not be created');
	window.location = 'homepage.php';
	</script>
	<?php
    }

$link->close();
?>