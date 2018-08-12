<?php
//connecting to database
$link = mysqli_connect("localhost","dharlley","dharlley")  or die("failed to connect to server !!");
mysqli_select_db($link,"dbmaintenance");


//creating variables
$inputfirst = $_POST['firstname'];

$inputlast = $_POST['lastname'];

$telephone = $_POST['telephonenum'];

$inputpass = $_POST['password'];

$inputemail = $_POST['email'];



$registeru = "INSERT INTO users ( first_name, last_name, telephonenum, password, email, access_level)
 VALUES ( '$inputfirst' , '$inputlast', '$telephone','$inputpass', '$inputemail', 'user')";

//checking if user account created successfully
if ($link->query($registeru) === TRUE) {
	?>
	<script type="text/javascript">
	alert('New user successfully created');
	window.location = 'login_screen.php';
	</script>
	<?php
}
// Alert if account not created successfully
 else {

 	
    ?>
	<script type="text/javascript">
	alert('There was a problem creating the user');
	window.location = 'login_screen.php';
	</script>
	<?php
}


$link->close();
?>