<?php
 // INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");
//Login and Logout code gotten from Kyle Harms lecture 16-login,(init.php)
?>

<!DOCTYPE html>
<html lang="en">

<?php include("includes/head.php")?>

<body>

  <?php include("includes/header.php");


  $params = array();
  $sql="SELECT tag_name FROM tags";
  $output= exec_sql_query($db, $sql, $params);
  $all_tags = $output->fetchAll();


  function all_tags($onetag){
      ?>

      <li class="taglogout">
        <button class="tagbtn"><?php echo htmlspecialchars($onetag["tag_name"])?> </button>
      </li>

      <?php
  }




  ?>

  <main>

    <div class="content-wrap">
      <article class="content">
        <section id="IntroSect">
          <h1> Welcome to Art Escape </h1>
          <!-- Source: https://www.facebook.com/HumanMedia.ro/photos/pb.100111786744026.-2207520000.1554910398./766460046775860/?type=3&theater-->
          <img src="images/wildlife.jpg" class="scaleimg" alt="Tree coming out of Book">
          <a class="refer" href="https://www.facebook.com/HumanMedia.ro/photos/pb.100111786744026.-2207520000.1554910398./766460046775860/?type=3&theater">HumanMedia.ro</a>
          <p> On this website, you shall be introduced to a catalog of animals and the such. You can also find all our current tags below. </p>
        </section>

        <section id="tags">
          <h1> All Tags </h1>
          <ul>

            <?php
              foreach($all_tags as $onetag){
                all_tags($onetag);
              }
            ?>

          </ul>
        </section>

        <section id="loginsect">
          <h1> Please input your details</h1>
          <form method="post" action="index.php">
            <fieldset>

              <p>
                <label> Username </label>
                <input type="text" name="username">
              </p>



              <p>
                <label> Password </label>
                <input type="password" name="password">
              </p>

              <button type="submit" name="submit" id="loginbtn"> Submit</button>
            </fieldset>
          </form>
        </section>

        <?php include("includes/finalref.php")?>

      </article>
    </div>

  </main>
  <!-- TODO: This should be your main page for your site. -->

</body>
</html>
