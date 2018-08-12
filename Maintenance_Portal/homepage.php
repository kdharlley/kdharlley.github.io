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
  <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="3000" >
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
      <li  class="active"><a href="homepage.php" style="color:#555"><span class="glyphicon glyphicon-home" style="color:#555" ></span> Home</a></li>
      <li><a href="report_problem.php" style="color:#555"><span class="glyphicon glyphicon-pencil" style="color:#555"></span> Report Problem</a></li>
      <li><a href="history.php" style="color:#555"><span class="glyphicon glyphicon-book" style="color:#555"></span> History</a></li>
      </ul> 
    </div>    
  </nav> 
  
  <!-- Welcome message -->
  <div class="container" id="container1">
    
    <div class="row">

          <img src="img/soscrest.png" alt="" class="img-responsive pull-left">
          <p> This is a maintenance portal, the solution to all your maintenance needs. It was enginnered for your benefit so please enjoy</p>
          
          <p><a href="register_worker.html" <?php if($_SESSION["access_level"]!="admin"){echo "hidden";} ?>> Register Worker(For admin use only) </a></p>  

    </div><!--end div row -->
  </div><!--end container -->

  
  <footer></footer>

  
  <!-- javascript -->
  <script src="http://code.jquery.com/jquery-latest.min.js"></script>
  <script src="js/bootstrap.min.js"></script> 
</body>
</html>
