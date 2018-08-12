<?php
//connecting to database and starting session
session_start();

$hostname = 'localhost';

$dbusername = 'dharlley';

$dbpassword = 'dharlley';

$msg = ''; 

$link = mysqli_connect($hostname,$dbusername,$dbpassword)  or die("failed to connect to server !!");
mysqli_select_db($link,"dbmaintenance");

if($link == false){
    echo "link unsuccessful";
}

//setting variables

$inputemail = $_POST['email'];

$inputpass = $_POST['pass'];




$checkuser = "SELECT email, access_level, first_name, last_name, password, user_id, telephonenum FROM users";
$result = $link->query($checkuser);

if ($result->num_rows > 0) {
    // xhecking if password and email correct
    while($row = $result->fetch_assoc()) {
    	if($row["email"]== $inputemail && $row["password"]==$inputpass)
    	{
    		$_SESSION["email"] = $row["email"];
    		$_SESSION["access_level"] = $row["access_level"];
    		$_SESSION["first_name"] = $row["first_name"];
    		$_SESSION["last_name"] = $row["last_name"];
    		$_SESSION["user_id"] = $row["user_id"];
    		$_SESSION["telephonenum"] = $row["telephonenum"];
    		$_SESSION['confirmsub']="0";
    		header('Location: homepage.php');	

    	}
        //response if email and password not the same
        else{
            ?>
            <script>
            alert('Wrong email or password');
            window.location = 'login_screen.php';
            </script>
             <?php
        }

    }
} 
 $link->close();


?>
