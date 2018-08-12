<?php
session_start();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <link href="css/bootstrap.min.css" rel="stylesheet"> 
    <link href="css/custom.css" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet"> 
</head>

<body>

  <!-- Logout navigation bar -->
  <div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container"> 
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <span class="glyphicon glyphicon-user"></span>
          <strong><?php echo $_SESSION['first_name'] ?></strong>
          <span class="glyphicon glyphicon-chevron-down"></span>
          </a>
          <ul class="dropdown-menu">
            <li>
            <div class="navbar-login">
              <div class="row">
                <div class="col-lg-8">
                  <p class="text-left"><strong><?php echo $_SESSION['first_name']." ". $_SESSION['last_name'] ?></strong></p>
                  <p class="text-left small"><?php echo $_SESSION['email'] ?></p>
                </div>
              </div>
            </div>
            </li>
            <li class="divider navbar-login-session-bg"></li>
            <li><a href="logout.php">Sign Out <span class="glyphicon glyphicon-log-out pull-right"></span></a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>

  <div class="c-wrapper">
  <!-- Pictures carousel -->
  <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="img/jumbotron.jpg" class="carouselimage img-responsive center-block" alt="grad">
      <div class="carousel-caption">
        <h1>Welcome to the SOS-HGIC Maintenance Website</h1>
      </div>
    </div>

    <div class="item">
      <img src="img/cultural.jpg" class="carouselimage img-responsive center-block" alt="Cultural">
      <div class="carousel-caption">
        <h1>Welcome to the SOS-HGIC Maintenance Website</h1>
      </div>
    </div>

    <div class="item">
      <img src="img/campus.jpg" class="carouselimage img-responsive center-block" alt="Campus">
      <div class="carousel-caption">
        <h1>Welcome to the SOS-HGIC Maintenance Website</h1>
      </div>
    </div>

    <div class="item">
      <img src="img/smile.jpg" class="carouselimage img-responsive center-block" alt="Smile">
      <div class="carousel-caption">
        <h1>Welcome to the SOS-HGIC Maintenance Website</h1>
      </div>
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
</div>

  <!-- main navigation controls -->
  <nav class="navbar navbar-default" role="navigation">
    <div class="navbar-header"> 
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse">
      <span class="sr-only"> Toggle navigation </span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse" id="collapse">
      <ul class="nav navbar-pills nav-justified ">
      <li><a href="homepage.php" style="color:#555"><span class="glyphicon glyphicon-home" style="color:#555" ></span> Home</a></li>
      <li><a href="report_problem.php" style="color:#555"><span class="glyphicon glyphicon-pencil" style="color:#555"></span> Report Problem</a></li>
      <li><a href="history.php" style="color:#555"><span class="glyphicon glyphicon-book" style="color:#555"></span> History</a></li>
      </ul> 
    </div>    
  </nav> 
  
  <div class="container">

    <!-- panels containg active maintenance jobs -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h1 class="panel-title text-center" style="font-size:2em;">History</h1>
        <h5 class="text-center"> List of active maintenance jobs </h5>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="panel panel-default">
          <?php
          // connecting to database

          $hostname = 'localhost';

          $dbusername = 'dharlley';

          $dbpassword = 'dharlley';

          $msg = ''; 

          $link = mysqli_connect($hostname,$dbusername,$dbpassword)  or die("failed to connect to server !!");
          mysqli_select_db($link,"dbmaintenance");

          if($link == false){
          echo "link unsuccessful";
          }

          //selecting records from database and outputting them in panels
          $findjob = "SELECT * FROM maintenance_job";
          $result = $link->query($findjob);
          while($row = $result->fetch_assoc()) {
          echo "<div class='row'><div class='panel panel-default'><div class='panel-heading'><h3 class='text-center'> Maintenance job " . $row['work_order'] . "</h3></div><div class='panel-body'><div class='row'><p> Name of reportee: " . $row['user_firstname'] ." ".$row['user_lastname']."</p><div class='row'><p>Location: ".$row['location']."</p><div class='row'><p>Description: ".$row['description'] ."</p><div class='row'><p>Job State: ".$row['job_state'] ."</p></div></div></div></div></div></div></div>";

          }
          
          ?>

          </div>
        </div>
      </div>
    </div>

    <!-- Editing Maintenance Jobs -->
    <form class="form-inline" name="editform" role="form" action="edit.php" method="POST">
      <div class="form-group"> 
        <div class="row">
          <label for="jobnumb"> Please enter the job number in the box below and click Edit/View to edit or view the maintenance job. For example for "Maintenance Job 8" enter "8". Thank you and God bless you </label>
        </div>
        <input type="text" id="jobnumb" name="jobnumb" placeholder="8" class="form-control">
        <input class="btn btn-default pull-right" type="Submit" name="edit" id="edit" value="Edit/View">
      </div>
    </form>

    <!-- Deleting maintenance jobs -->
    
    <form class="form-inline" name="deleteform" role="form" action="delete.php" method="POST" <?php if($_SESSION["access_level"]!="admin"){echo "hidden";} ?>>
      <div class="form-group"> 
        <div class="row">
          <label for="del"> Please enter the job number in the box below and click Delete to delete the maintenance job. For example for "Maintenance Job 8" enter "8". Thank you and God bless you </label>
        </div>
        <input type="text" id="del" name="del" placeholder="8" class="form-control">
        <input class="btn btn-default pull-right" type="Submit" name="delete" id="delete" value="Delete">
      </div>
    </form>


  </div>
  <footer></footer>
  
<!-- javascript -->
 <script src="http://code.jquery.com/jquery-latest.min.js"></script>
 <script src="js/bootstrap.min.js"></script> 
</body>
</html>
