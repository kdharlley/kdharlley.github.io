<?php
  include("includes/init.php");
  $title="LEP | Executive Board";
  const max_size = 1000000;
  $name="";
  $position="";
  $introduction="";
  $valid=TRUE;
  $messages=array();
  $searchval="";

  if(isset($_POST["submitform"]) && is_user_logged_in()){

    $image_info = $_FILES["eboardpic"];
    $name=filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
    $position=filter_input(INPUT_POST, "position", FILTER_SANITIZE_STRING);
    $introduction=filter_input(INPUT_POST, "introduction", FILTER_SANITIZE_STRING);

    if ($name==NULL){
      $valid=FALSE;
      array_push($messages,"The name cannot be empty");
    }

    if($position==NULL){
      $valid=FALSE;
      array_push($messages,"The position cannot be empty");
    }

    if($introduction==NULL){
      $valid=FALSE;
      array_push($messages,"The introduction cannot be empty");
    }

    if($image_info['error']==UPLOAD_ERR_OK && $valid){
      $db->beginTransaction(); // transaction required since some of the steps rely on previous ones executing properly

      $image_name=basename($image_info["name"]);
      $extension = strtolower( pathinfo($image_name, PATHINFO_EXTENSION) );

      $sql = "INSERT INTO eboard(name, position, extension, bio) VALUES (:name, :position, :extension, :bio);";

      $params = array(
        ':position'=>$position,
        ':name' => $name,
        ':bio' => $introduction,
        ':extension' => $extension
      );

      $results = exec_sql_query($db, $sql, $params)->fetchAll();
      $temp_name = $image_info["tmp_name"];
      $id_db=$db->lastInsertId();
      $new_path = "uploads/eboard/".$id_db.".".$extension."";
      move_uploaded_file( $image_info["tmp_name"], $new_path );

      $db->commit();

    } else {
      if($image_info['error']!=UPLOAD_ERR_OK){
        array_push($messages,"There was a problem with the data you supplied for Photo");
      }
    }
  }

  if(isset($_GET["order_by"])){
    $orderby=filter_input(INPUT_GET, "order_by", FILTER_SANITIZE_NUMBER_INT);
  }

  if (isset($_GET["order_by"]) && $orderby!=1 && !(isset($_GET['searchform'])) ){
    if ($orderby==2){
      $params = array();
      $sql="SELECT * FROM eboard ORDER BY 2";
      $output= exec_sql_query($db, $sql, $params);
      $searchresults =$output->fetchAll();
      $sources = array();

    } else {
      $params = array();
      $sql="SELECT * FROM eboard ORDER BY 3";
      $output= exec_sql_query($db, $sql, $params);
      $searchresults =$output->fetchAll();
      $sources = array();
    }

  } else {
    if (!(isset($_GET['searchform']))){
      $sql="SELECT * FROM eboard;";
      $params = array();
      $output= exec_sql_query($db, $sql, $params);
      $searchresults =$output->fetchAll();

    } else {
      $searchval= filter_input(INPUT_GET, "search_value", FILTER_SANITIZE_STRING);
      $params = array(
      ':searchval' => $searchval
      );
      $sql="SELECT * FROM eboard WHERE position LIKE '%' || :searchval || '%'
      UNION SELECT * FROM eboard WHERE name LIKE '%' || :searchval || '%'
      UNION SELECT * FROM eboard WHERE bio LIKE '%' || :searchval || '%';
      ";
      $output= exec_sql_query($db, $sql, $params);
      $searchresults =$output->fetchAll();
    }
  }

  function eboard_member($record){
    ?>
    <div class="EboardMember">
      <img src="uploads/eboard/<?php echo htmlspecialchars($record["id"]).".".htmlspecialchars($record["extension"]); ?>" class="profilepic" alt="<?php echo htmlspecialchars($record["name"]); ?>">
      <?php if($record["id"]<=3) { ?>
      <!-- Source: http://orgsync.rso.cornell.edu/org/lep/meettheboard-->
      <cite>Source: <a href='http://orgsync.rso.cornell.edu/org/lep/meettheboard'>Cornell LEP</a></cite>
      <?php } ?>


      <p class="eb_info"> Name: <?php echo htmlspecialchars($record["name"]); ?></p>
      <p class="eb_info">Position: <?php echo htmlspecialchars($record["position"]); ?></p>

      <?php if (is_user_logged_in()){ ?>
      <a class="button" href="<?php echo 'member.php?'.http_build_query(array('id'=>htmlspecialchars($record["id"]), 'edit'=>htmlspecialchars($record["id"]))) ?>">Edit</a>
      <a class="button" href="<?php echo 'member.php?'.http_build_query(array('id'=>htmlspecialchars($record["id"]))) ?>">View</a>
      <a class="button" href="<?php echo 'member.php?'.http_build_query(array('delete'=>htmlspecialchars($record["id"]), 'id'=>htmlspecialchars($record["id"]))) ?>">Delete </a>

      <?php }  else {?>
      <a class="button" href="<?php echo 'member.php?'.http_build_query(array('id'=>htmlspecialchars($record["id"]))) ?>">View</a>

      <?php } ?>

    </div>

  <?php
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
        <div class="main_content">

          <h1 class="centered">Meet the Executive Board</h1>

          <div id="search-eboard">
            <form method="get" action="eboard.php">
                <input type="text" id="searchinput" placeholder="Search for Name, Position, or Bio" name="search_value" value="<?php echo $searchval?>">
                <button type="submit" class="button" name="searchform" id="search_things"> Search</button>
            </form>
          <div>

          <?php if(is_user_logged_in()){ ?>
            <div id="orderBy">
              <p> Order by: </p>
              <a class="button" href="<?php echo 'eboard.php?'.http_build_query(array('order_by'=>1)) ?>"> Default</a>
              <a class="button"  href="<?php echo 'eboard.php?'.http_build_query(array('order_by'=>2)) ?>">Name </a>
              <a class="button" href="<?php echo 'eboard.php?'.http_build_query(array('order_by'=>3)) ?>">Title </a>
            </div>
          <?php } ?>

          <section class="gallery">

            <?php
            foreach($searchresults as $searchresult){
              eboard_member($searchresult);
            }
            if(isset($_GET['searchform']) && sizeof($searchresults)!=0){
              echo "<a class='button right' href='eboard.php'>Back to EBoard Page</a>";
            }

            if (sizeof($searchresults)==0){
              ?>
              <div class="centered">
                <p> No results found. Please try again!</p>
                <!-- Source: https://www.google.com/search?q=funny+dog+faces&tbm=isch&source=iu&ictx=1&fir=SNcVu9OHcdL-OM%253A%252CaYB28Uf__nan-M%252C_&vet=1&usg=AI4_-kRRlzKp5Vo9Ir1youdrZ0r0uEwc_Q&sa=X&ved=2ahUKEwjClPP6kobiAhUFSK0KHRvqDVQQ9QEwBHoECAcQDA&cshid=1557119831250718#imgrc=SNcVu9OHcdL-OM: -->
                <img class="dogpic" src="images/dog_2.jpg" alt="dog faces">
                <cite> <br/> Source: <a href="https://www.google.com/search?q=funny+dog+faces&tbm=isch&source=iu&ictx=1&fir=SNcVu9OHcdL-OM%253A%252CaYB28Uf__nan-M%252C_&vet=1&usg=AI4_-kRRlzKp5Vo9Ir1youdrZ0r0uEwc_Q&sa=X&ved=2ahUKEwjClPP6kobiAhUFSK0KHRvqDVQQ9QEwBHoECAcQDA&cshid=1557119831250718#imgrc=SNcVu9OHcdL-OM:">Google</a></cite>
                <p><a href="eboard.php">See all Eboard Members</a></p>
              </div>
            <?php } ?>

          </section>

          <?php if (is_user_logged_in() && !isset($_GET['searchform'])){ ?>

            <p id="add-member" class="link"><a role="button">Add an Executive Board Member</a></p>

            <section class="eform hidden" id="addMember">

              <div>
                <div class="electricform">
                  <h1>Add an Executive Board Member</h1>
                  <p id="message"> * Required</p>
                  <form id="eboard-upload-form" method="post" action="eboard.php" enctype="multipart/form-data">
                  <?php
                  foreach ($messages as $message) {
                  echo "<p id='message'><strong>".htmlspecialchars($message)."</strong></p>\n";
                  }?>

                    <p>
                      <input type="hidden" name="max_size" value="<?php echo max_size; ?>">
                      <label class="asterisk"> <strong>Photo</strong></label>
                      <input type="file" name="eboardpic">
                    </p>

                    <p>
                      <label class="asterisk"><strong> Name </strong></label>
                      <input type="text" name="name" value="<?php echo htmlspecialchars($name)?>">
                    </p>
                    <p>
                      <label class="asterisk"> <strong>Position</strong> </label>
                      <input type="text" name="position" value="<?php echo htmlspecialchars($position) ?>">
                    </p>
                    <p>
                      <label class="below asterisk"><strong> Introduction</strong> </label>
                      <textarea name="introduction" rows="5" cols="60"><?php echo htmlspecialchars($introduction)?></textarea>
                    </p>


                    <button type="submit" name="submitform" id="eboard_submit"> <strong>Submit</strong></button>
                  </form>

                </div>
              </div>
              <p id="hide-form"><a role="button">Show Less</a></p>
            </section>
            <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include("includes/footer.php")?>

  <script src="scripts/jquery-3.2.1.min.js"></script>
  <script src="scripts/eboard.js"></script>

</body>
</html>
