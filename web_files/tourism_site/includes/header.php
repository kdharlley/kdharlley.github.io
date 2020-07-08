<?php

?>
<header>
    <nav id="navbar">
      <p id="brand"> <strong>Visit Ghana</strong></p>
      <ul>
        <li><a href="connected.php" <?php if (isset($connected)) {echo "id=".$connected;} ?>> Stay Connected </a></li>
        <li><a href="attractions.php" <?php if (isset($attractions)) {echo "id=".$attractions;} ?>> Attractions </a></li>
        <li><a href="index.php" <?php if (isset($home)) {echo "id=".$home;} ?>> Home </a></li>
      </ul>
    </nav>
    <figure>
        <!--Landing Images by Andrew Earnes Viewable at: https://adventure.com/ghana-cape-coast-west-africa/ -->
        <img src="<?php echo $landingimagesrc ?>" id="LandingImage" alt="<?php echo $imagedescrip ?>">
    </figure>
  </header>
