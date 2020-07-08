<?php
// DO NOT REMOVE!
include("includes/init.php");
// DO NOT REMOVE!
include("includes/searchNoutput.php");

?>
<!DOCTYPE html>
<html lang="en">

<?php include("includes/head.php"); ?>
<body>
  <header>

    <figure id="welcomeInfo">
        <!--Jumbotron Image from https://www.pexels.com/photo/green-lawn-grass-958168/ -->
        <img src="images/grassybackg.jpg" id="jumbotron" alt="Plain Background">
        <div id="txtOverlay">
          <figure>
            <!-- Icon from https://living.cornell.edu/dine/wheretoeat/AYCTEdiningrooms/beckerhousedining.cfm-->
            <img src="images/Beckerlogo.png" id="BeckIcon" alt="Becker Logo">

          </figure>
          <h1>Welcome to The Carl Becker Music Library </h1>
        </div>
    </figure>

  </header>
  <div class="content-wrap">
    <article class="content">
      <section id="BorderSect">
        <h1 class="SectHeading"> MUSIC CATALOGUE </h1>
        <p> Welcome to the Carl Becker Music Library. On this website, you will be able to see all records stored in our library and would also be able to search for specific records. This website was designed for you so please enjoy! (To view all records click the search button with nothing in the search bar).</p>

        <form method="get" action="index.php">
          <fieldset>
            <p>
              <label id="searchlbl"> Search Below: </label>

              <input type="text" id="search" placeholder="Please input your favourite artist, music title, etc below and then click search to the left" name="searchvalue" value="">

              <button type="submit" name="search" value="Search" class="submitbutton">Search </button>
            </p>
          </fieldset>
        </form>
      </section>
      <section id="recordsDisplay">
      <?php
      if (!(isset($_GET['search']))){
        echo "<h3 class='SectHeading'> Currently showing full collection. </h3>";
      }
      else if (count($records)==0){
        echo "<h1 class='SectHeading'> No Results Found</h1>";
      }
      else if ($searchvalue==""){
        echo "<h1 class='SectHeading'> Currently showing full collection.</h1>";
      }
      else {
        echo "<h3 class='SectHeading'> Search Results for: ".htmlspecialchars($searchvalue).".</h3>";
      }
      foreach($records as $record){
        song_details($record);
      }
      ?>
      </section>
      <section id="NewRecord">
      <?php if (!(isset($_POST['submit']))) { ?>
        <!-- Image Source https://living.cornell.edu/dine/wheretoeat/AYCTEdiningrooms/beckerhousedining.cfm-->
        <img src="images/Beckerlogo.png" id="NewRecIcon" alt="Becker Logo">
        <cite><a href="https://living.cornell.edu/dine/wheretoeat/AYCTEdiningrooms/beckerhousedining.cfm"> Source: Cornell Living </a></cite>
        <h1 class="SectHeading"> Add a new Record to our Library </h1>
        <form method="post" action="index.php">
          <fieldset>

            <p>
              <label> Artist </label>
              <input type="text" name="artist">
            </p>

            <p>
              <label> Genre </label>
              <input type="text" name="genre">
            </p>

            <p>
              <label> Title </label>
              <input type="text" name="title" required>
            </p>

            <p>
              <label> Release Year </label>
              <input type="number" name="relyear">
            </p>

            <button type="submit" class="submitbutton" name="submit"> Submit</button>
          </fieldset>
        </form>
      </section>

      <?php } else { ?>
        <!-- Image Source https://living.cornell.edu/dine/wheretoeat/AYCTEdiningrooms/beckerhousedining.cfm/-->
        <img src="images/Beckerlogo.png" id="NewRecIcon" alt="Becker Logo">
        <cite><a href="https://living.cornell.edu/dine/wheretoeat/AYCTEdiningrooms/beckerhousedining.cfm"> Source: Conell Living </a></cite>
        <h1 class="SectHeading"> Add a new Record to our Library </h1>
        <form method="post" action="index.php">
          <fieldset>
            <h3> Thank you for updating our library! </h3>
            <button type="submit" class="submitbutton" name="reload"> Reload</button>
          </fieldset>
        </form>
      </section>

      <?php } ?>

    </article>
  </div>

  <?php include("includes/footer.php"); ?>


  <!-- TODO: This should be your main page for your site. -->

</body>
</html>
