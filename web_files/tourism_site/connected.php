<?php
include("includes/init.php");
$landingimagesrc = "images/boatscoast.jpg";
$imagedescrip ="Boats on Beachs";
$connected= "activepage";
$valid_form= TRUE;
$firstname_valid= TRUE;
$lastname_valid=TRUE;
$email_valid=TRUE;


if (isset($_POST['submit'])) {
  $firstname= $_POST['firstname'];
  $midname= $_POST['midname'];
  $lastname= $_POST['lastname'];
  $email = $_POST['email'];

  if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $email_valid=FALSE;
  }

  if (empty($firstname)){
    $firstname_valid=FALSE;
  }

  if (empty($lastname)){
    $lastname_valid=FALSE;
  }

  if (empty($email)){
    $email_valid=FALSE;
  }

  $valid_form=$lastname_valid && $firstname_valid && $email_valid;
}
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Stay Connected</title>

    <link rel="stylesheet" type="text/css" href="styles/stylesheet.css" media="all" />
  </head>


  <body>
    <?php include("includes/header.php"); ?>
    <div class="content-wrap">
      <article class="content">

        <?php if(isset($_POST['submit']) && $valid_form==TRUE) { ?>
        <section id="confirmmation">

          <h3> You are officially set and connected</h3>
          <p> Thank you
            <?php

            if($midname!=""){
              echo htmlspecialchars($firstname)." ".htmlspecialchars($midname)." ".htmlspecialchars($lastname);
            }
            else{
              echo htmlspecialchars($firstname)." ".htmlspecialchars($lastname);
            }
             ?>
            for connecting with us. You shall receive an email from us soon with regards to deals, tickets to Ghana, etc. We will contact you at <?php echo htmlspecialchars($email)?>.
          </p>
          <a href="index.php" id="homebutton">Home </a>

        </section>

        <?php } else { ?>

        <section class="welcomesect">
          <h1> Stay Connected </h1>

          <figure>
            <!-- Source: https://bikeexpedition.com.br/destinos/africa-do-sul/rhc-past-events/0/-->
            <img src="images/sunsetimage.jpg" id="topimage" alt="Sunset Image">
            <figcaption>
                  Source: <cite><a href="https://bikeexpedition.com.br/destinos/africa-do-sul/rhc-past-events/0/">https://bikeexpedition.com.br/destinos/africa-do-sul/rhc-past-events/0/</a></cite>
            </figcaption>
          </figure>

          <p> We have a lot more information for you. Fill the form below, so we can keep you connected with updates, newsletters and make the possibility of going to Ghana a reality. By filling this form, you will have access to deals, promotions, and other sorts of goodies which will finally allow you to VISIT GHANA.  </p>

          <form method="post" action="connected.php">
            <fieldset>

              <p class="formerror <?php if(!$firstname_valid==FALSE || isset($_POST["submit"])==FALSE){ echo "hidden";} ?>" > You need to input First Name </p>
              <p><label id="fname"> First Name </label><input type="text" name="firstname"
              value="<?php if (isset($firstname)) {echo htmlspecialchars($firstname);}?>"></p>

              <!--Middle Name is not a required field -->
              <p><label id="mname"> Middle Name </label><input type="text" name="midname" value="<?php if (isset($lastname)){echo htmlspecialchars($midname);}?>"></p>

              <p class="formerror <?php if(!$lastname_valid==FALSE || isset($_POST["submit"])==FALSE){ echo "hidden";} ?>"> You need to input Last Name </p>
              <p><label id="lname"> Last Name </label><input type="text" name="lastname" value="<?php if (isset($lastname)){echo htmlspecialchars($lastname);}?>"></p>

              <p class="formerror <?php if(!$email_valid==FALSE || isset($_POST["submit"])==FALSE){ echo "hidden";} ?>"> You need to input a valid Email Address </p>
              <p><label id="emaill"> Email </label><input type="text" name="email" value="<?php if (isset($email)){ echo htmlspecialchars($email);}?>"></p>

              <input type="submit" name="submit" value="Connect to Ghana" id="submitbutton">
            </fieldset>
          </form>
        </section>

        <?php } ?>

      </article>
    </div>



    <?php include("includes/footer.php"); ?>
  </body>

</html>
