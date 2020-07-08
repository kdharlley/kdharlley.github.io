<?php
 // INCLUDE ON EVERY TOP-LEVEL PAGE!

//Login and Logout code gotten from Kyle Harms lecture 16-login,(init.php)
if (isset($_POST["submit"])){
  //they used trim
$session_messages = array();
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
log_in($username, $password);
} else{
  session_login();
}

if (isset($_POST['logout'])){
  log_out();
}


?>

<header>
  <nav id="topnav">
    <div id="logform">
      <form method="POST" action="index.php">
        <fieldset>
          <?php if(is_user_logged_in()){ ?>
          <button type="submit" name="logout" id="logbutton"> Logout, <?php echo htmlspecialchars($current_user['first_name'])?> </button>
          <?php } else { ?>
          <button type="submit" name="login" id="logbutton"> Login </button>
          <?php
          }
          ?>
        </fieldset>
      </form>
    </div>
    <?php if(is_user_logged_in()){ ?>
    <div class="centered">
      <ul>
        <li class="pipeborder"><a href="index.php" > Home </a></li>
        <li class="pipeborder"><a href="images.php" > Images </a></li>
        <li><a href="uploads.php"> Upload </a></li>
      </ul>
    </div>
    <?php } else { ?>
    <div class="logoutcentered">
      <ul>
        <li class="pipeborder"><a href="index.php" > Home </a></li>
        <li><a href="images.php" > Images </a></li>
      </ul>
    </div>
    <?php } ?>
  </nav>
  <figure>
      <!-- Source: https://ya-webdesign.com/download.html -->
      <img src="images/laketrees.png" id="JumboImg" alt="">
  </figure>
  <?php

  ?>
</header>
