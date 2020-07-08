<?php
  include("includes/init.php");
  $title="LEP | Log In";
  $messages=array();
  if (isset($_POST['submit'])){
    log_in($username, $password);
  }
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css"/>
  <title><?php echo $title; ?></title>
</head>

<body>
  <div>
    <?php include("includes/header.php")?>
      <div class="main">
        <?php include("includes/navigation_bar.php")?>
        <div class="right_side">

            <?php
            if (is_user_logged_in()){
              echo "<div class='main_content centered'>";
                echo "<p>Logged in successfully as user <strong>".htmlspecialchars($current_user['username'])."</strong>.<br/>Now it's time to explore the website!</p><br/>";

                echo "<!-- Source: https://www.google.com/search?biw=1372&bih=684&tbm=isch&sa=1&ei=Kd3PXO-ENY-f_Qav5q_ABg&q=dog+smile&oq=dog+smile&gs_l=img.3..35i39j0l3j0i67j0l5.15137.16220..16340...0.0..0.100.686.8j1......1....1..gws-wiz-img.XrB14xy-TKk#imgdii=OOd0aIGzk2dfWM:&imgrc=X2Xn5HDheriz2M: -->";

                echo "<img class='dogpic' src='images/dog.jpg' alt='doggo'>";

                echo "<cite><br/>Source: <a href='https://www.google.com/search?biw=1372&bih=684&tbm=isch&sa=1&ei=Kd3PXO-ENY-f_Qav5q_ABg&q=dog+smile&oq=dog+smile&gs_l=img.3..35i39j0l3j0i67j0l5.15137.16220..16340...0.0..0.100.686.8j1......1....1..gws-wiz-img.XrB14xy-TKk#imgdii=OOd0aIGzk2dfWM:&imgrc=X2Xn5HDheriz2M:'>Google</a></cite>";

              echo "</div>";

            } else{
              include ("includes/log_in.php");
            }?>

        </div>
      </div>
    </div>

  <?php include("includes/footer.php")?>

</body>
</html>
