<?php
  include("includes/init.php");
  $title="LEP | About Us"
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
    <div class='main'>
      <?php include("includes/navigation_bar.php")?>
      <div class="right_side">
        <div class="main_content">

          <h2>About Us</h2>

          <p><br/>The Cornell Public Service Center (PSC) Language Expansion Program (LEP), formerly known as the Language Pairing Program, is a student-led program that fosters language learning in a comfortable and encouraging environment for its participants. LEP provides a unique opportunity for individuals in the Cornell community to pursue their interest in language study and to improve their speaking abilities.</p>

          <p><br/>In order to help dedicated Cornellian language learners practice in an atmosphere that is conducive to the exchange of cultural knowledge and understanding, LEP has introduced the “Language Corner.” Through this initiative, LEP is seeking to reduce language barriers and to enable students to learn more about both the technical aspects of different languages and the culture that envelops them.</p>

          <p><br/>Our goal is to involve groups of students in a joint effort to improve each other’s speaking abilities in an environment that simulates group immersion. We will be hosting weekly Language Corners in which students will meet informally to practice. Students will be instructed to use only their target language in conversation, but no prior knowledge of the language is required. Both faculty members and native speakers are encouraged to attend, as we plan to integrate interactive programs, to increase cultural exposure, and to guide those who have less experience speaking the target language. Language learners will now be able to meet as a group, interact with other students and native speakers, and improve their proficiency in their language of study. </p> <br/>

         <img src="images/people.jpg" alt="people" id="people">
         <!-- Source: https://www.facebook.com/langexpansion/photos/a.1463720633848704/1881154388771991/?type=1&theater-->
          <div class="centered">
            <cite>Source: <a href='https://www.facebook.com/langexpansion/photos/a.1463720633848704/1881154388771991/?type=1&theater'>Cornell LEP</a></cite>
          </div>

        </div>
      </div>
    </div>
  </div>

  <?php include("includes/footer.php")?>

</body>
</html>
