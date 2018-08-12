<?php
// starting session and connecting to database
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
$del = $_POST['del'];

//SQL for deleting job
$deletejob = "DELETE FROM maintenance_job WHERE work_order='$del'";

//running query checking whether row was deleted or not also adding appropiate error messages
mysqli_query($link, $deletejob);


if (mysqli_affected_rows($link)> 0) {
        ?>
    <script type="text/javascript">
    alert('Job was successfully deleted');
    window.location = 'homepage.php';
    </script>
    <?php
            
}
else {

    ?>
    <script type="text/javascript">
    alert('There is no maintenance job like that');
    window.location = 'history.php';
    </script>
    <?php
}

 $link->close();

?>