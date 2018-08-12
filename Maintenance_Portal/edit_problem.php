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

  <div class="container" id="container1">

  <h1 class="text-center"> Reporting Form </h1>
  <p class="text-center"> Please fill this form carefully </p>
  <img src="img/soscrest.png" alt="" class="img-responsive center-block">

  <!-- Requestor Name, Phone Number and Date and Time of Submission -->
  <form class="form-inline" name="registerform" role="form" action="edit_prob.php" method="POST">
    <div class="row"> 
      <div class="form-group col-xs-4">
        <div class=row>
          <label for="requestnm">Requestor name</label>
        </div>
        <p> <?php echo $_SESSION['first_name'], " ", $_SESSION['last_name'] ?></p> 
      </div>
      <div class="form-group col-xs-4">
        <div class="row">
          <label for="phonenum">Phone number</label>
        </div>
        <p> <?php echo $_SESSION['telephonenum']?></p> 
      </div>
      <div class="form-group col-xs-4">
        <div class="row">
          <label for="datesub"> Date and Time of Submission </label>
        </div>
        <p id="curr_date"><?php echo $_SESSION["dr_maint"] ?></p>
      </div>
    </div> <!--end row and all form groups -->


    <!-- Job Area -->
    <h3 class="text-center row"> Job Area </h3>

    <div class="text-center">
      <div class="radio col-xs-4">
        <label for="hostelsradio">
        <input type="radio" name="jobrad" id="hostelsradio" value="Hostels" required <?php if($_SESSION["job_area"]== "Hostels"){ echo "CHECKED";} ?>>
        Hostels
        </label>
      </div>
      <div class="radio col-xs-4">
        <label for="collegeradio">
        <input type="radio" name="jobrad" id="collegeradio" value="College" required <?php if($_SESSION["job_area"]== "College"){ echo "CHECKED";} ?>>
        College
        </label>
      </div>
      <div class="col-xs-4">
        <label for="staffrradio">
        <input type="radio" name="jobrad" id="staffrradio" value="Staff" required <?php if($_SESSION["job_area"]== "Staff"){ echo "CHECKED";} ?>>
        Staff residence
        </label>
      </div>
    </div>

    <!-- Location, Accurate and Complete Description of Work and Facility fields -->
    <div class="row">
      <div class="form-group col-xs-4">
        <div class=row>
          <label for="locationtext">Location</label>
        </div>
        <input type="text" class="form-control" required name="locationtext" id="locationtext" placeholder="Nile Room 2 Side A" value="<?php echo $_SESSION["location"] ?>">
      </div>
      <div class="form-group col-xs-4">
        <div class="row">
          <label for="descriptionwrk">Accurate and Complete description of work</label>
        </div>
        <textarea class="form-control" rows="5" required name="descriptionwrk" id="descriptionwrk" ><?php echo $_SESSION["description"]?> </textarea>
      </div>
      <div class="col-xs-4">
        <div class="form-group">
          <div class="row">
            <label for="selfacility"> Facility </label>
          </div>
          <select class="form-control" required name="selfacility" id="selfacility">
            <option value="1" <?php if($_SESSION["facility_id"] == "1"){ echo "selected='selected'";} ?>> Carpenter </option>
            <option value="2" <?php if($_SESSION["facility_id"] == "2"){ echo "selected='selected'";} ?>> Plumber</option>
            <option value="3" <?php if($_SESSION["facility_id"] == "3"){ echo "selected='selected'";} ?>> Electrician</option>
          </select>
        </div>
      </div>
    </div>

    <!-- State of Job  -->
    <div class="col-xs-12 text-center">
      <h3 class="text-center row"> State of Job </h3>
      <div class="row text-center">
        <div class="radio col-xs-4">
          <label for="emergrad">
          <input type="radio" name="jobstate" id="emergrad" value="Emergency" required <?php if($_SESSION["job_state"] == "Emergency"){ echo "CHECKED";} ?>>
          Emergency
          </label>
        </div>
        <div class="radio col-xs-4">
          <label for="urgrad">
          <input type="radio" name="jobstate" id="urgrad" value="Urgent" required <?php if($_SESSION["job_state"] == "Urgent"){ echo "CHECKED";} ?>>
          Urgent
          </label>
        </div>
        <div class="radio col-xs-4">
          <label for="routrad">
          <input type="radio" name="jobstate" id="routrad" value="Routine" required <?php if($_SESSION["job_state"] == "Routine"){ echo "CHECKED";} ?>>
          Routine
          </label>
        </div>
      </div>
    </div>

    <!-- All Date and Time Fields -->
    <div class="row">
      
      <div class="col-xs-4">
        <label for="dtr_mo""> Date and Time received by Maintenance Officer(admin)</label>
        <input class="form-control" type="textbox-n" value="<?php echo $_SESSION["dr_maint"]?>" name="dtmaint" placeholder=<?php echo $_SESSION["dr_maint"]?> id="dtr_mo" onfocus="(this.type='datetime-local')" <?php if($_SESSION["access_level"]!="admin"){echo "disabled";} ?>  <?php if($_SESSION["access_level"]=="admin"){echo "required";} ?>></input>
      </div>

      
      <div class="col-xs-4">
        <label for="dorm"> Date and Time of Request for Materials(admin)</label>
        <input class="form-control" type="textbox-n" value="<?php echo $_SESSION["dr_materials"] ?>" id="dorm" name="dorm" onfocus="(this.type='datetime-local')" <?php if($_SESSION["access_level"]!="admin"){echo "disabled";} ?> s></input>
      </div>

      <div class="col-xs-4">
        <label for="dra"> Date and Time received by Artisan/Artisans(admin)</label>
        <input class="form-control" type="textbox-n" value="<?php echo $_SESSION["dr_artisan"] ?>" id="dra" name="dra" onfocus="(this.type='datetime-local')"<?php if($_SESSION["access_level"]!="admin"){echo "disabled";} ?>  ></input>
      </div>

    </div>

    <div class="row">
      <div class="col-xs-4">
        <label for="docw"> Date and Time of Commencement of Work(admin)</label>
        <input class="form-control" type="textbox-n" value="<?php echo $_SESSION["dt_commenc"] ?>" id="docw" name="docw" onfocus="(this.type='datetime-local')" <?php if($_SESSION["access_level"]!="admin"){echo "disabled";} ?>  ></input>
      </div>

      <div class="col-xs-4">
        <label for="dosm"> Date and Time of Supply of Materials(admin)</label>
        <input class="form-control" type="textbox-n" id="dosm" name="dosm"  value="<?php echo $_SESSION["ds_materials"]  ?>"" onfocus="(this.type='datetime-local')" <?php if($_SESSION["access_level"]!="admin"){echo "disabled";} ?>  ></input>
      </div>

      <div class="col-xs-4">
        <label for="djc"> Date and Time Job was Completed(admin)</label>
        <input  class="form-control" type="textbox-n" name="djc" id="djc" value="<?php echo $_SESSION["dc_job"]?>"" onfocus="(this.type='datetime-local')" <?php if($_SESSION["access_level"]!="admin"){echo "disabled";} ?>  ></input>
      </div>
    </div>


    <!-- Comments section -->
    <div class="form-group col-xs-4">
      <div class="row">
        <label for="commentss">Comments</label>
      </div>
      <textarea required class="form-control" rows="5" name="commentss" id="commentss" value=<?php echo $_SESSION["comments"] ?>> 
      <?php echo $_SESSION["comments"]?> </textarea>
    </div>
    
    <!-- Submit button -->
    <div class="row col-xs-12">
      <input class="btn btn-default pull-right" type="Submit" name="Submit" id="Submit" value="Submit">
    </div>
  </form>
 
    
  </div>
  <footer> By clicking submit you are giving permission for workers to proceed with repairs</footer>



  <!-- javascript -->
  <script src="http://code.jquery.com/jquery-latest.min.js"></script>
  <script src="js/bootstrap.min.js"></script> 
</body>
</html>
