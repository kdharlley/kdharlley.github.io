<?php
//connecting to dataase
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

//selecting record data
$jobnumb = $_POST['jobnumb'];

$findjob = "SELECT work_order, user_id, dr_maint, dr_artisan, dr_materials, ds_materials, dc_job, location, description, job_state,  job_area, facility_id, dt_commenc, comments  FROM maintenance_job";
$result = $link->query($findjob);

if ($result->num_rows > 0) {
    // saving record data into sessions and going to page
    while($row = $result->fetch_assoc()) {
    	if($row["work_order"]== $jobnumb )
    	{

            //checking if user has accss to page
    		if($_SESSION["access_level"]=="admin"){
    		$_SESSION["work_order"] = $row['work_order']; 
    		$_SESSION["dr_maint"] = $row["dr_maint"];
    		$_SESSION["dr_artisan"] = $row["dr_artisan"];
    		$_SESSION["dr_materials"] = $row["dr_materials"];
    		$_SESSION["ds_materials"] = $row["ds_materials"];
    		$_SESSION["dc_job"] = $row["dc_job"];
    		$_SESSION["location"] = $row["location"]; 
    		$_SESSION["description"] = $row["description"];
    		$_SESSION["job_state"] = $row["job_state"];
    		$_SESSION["job_area"] = $row["job_area"];
    		$_SESSION["facility_id"] = $row["facility_id"]; 
    		$_SESSION["dt_commenc"] = $row["dt_commenc"];
    		$_SESSION["comments"] = $row["comments"];

    		
    		header('Location: edit_problem.php');	
    		
    		}

            //checking if user has access to page
    		else if($_SESSION["user_id"]==$row["user_id"]){
            $_SESSION["work_order"] = $row['work_order'];
    		$_SESSION["location"] = $row["location"]; 
    		$_SESSION["description"] = $row["description"];
    		$_SESSION["job_state"] = $row["job_state"];
    		$_SESSION["job_area"] = $row["job_area"];
    		$_SESSION["facility_id"] = $row["job_area"];
    		$_SESSION["comments"] = $row["comments"];
            $_SESSION["dr_maint"] = $row["dr_maint"];
            $_SESSION["dr_artisan"] = $row["dr_artisan"];
            $_SESSION["dr_materials"] = $row["dr_materials"];
            $_SESSION["ds_materials"] = $row["ds_materials"];
            $_SESSION["dc_job"] = $row["dc_job"];
            $_SESSION["dt_commenc"] = $row["dt_commenc"];

    		header('Location: edit_problem.php');
    		
    		} 
    	}

    }
} 
//alert in case user does nnot have access or no existing maintenance job like that
?>

<script>
alert('There is no existing maintenance job number like that or you do not have access');
window.location = 'history.php';
</script>
<?php

 $link->close();

?>