  <!doctype html>
<html>
<head>
    <meta charset="utf-8">   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <link href="css/bootstrap.min.css" rel="stylesheet"> 
    <link href="css/custom.css" rel="stylesheet"> 
 
</head>

<body>
  
  <div class="container" id="container1">
    <h1 class="text-center"> Welcome to the SOS-HGIC Maintenance Portal </h1>
    <img src="img/soscrest.png"  alt="" class="center-block img-responsive">
    <form role="form" action="login.php" method="POST"><!-- Login Form -->
      <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" required placeholder="Email" name="email">
      </div><!-- Close first form group -->
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" required id="password" placeholder="Password" name="pass">
      </div><!-- Close second form group -->

      <input class="btn btn-default pull-right" type="Submit" name="Login" id="Login" value="Login">
      
    
    </form><!-- Close form-->
    <p><a href="register.html"> New User? Register </a></p>
 
  </div><!-- Close container -->

<!-- javascript -->
  <script src="http://code.jquery.com/jquery-latest.min.js"></script>
  <script src="js/bootstrap.min.js"></script> 
</body>
</html>
