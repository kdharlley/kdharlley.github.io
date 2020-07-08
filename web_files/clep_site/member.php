<?php
include("includes/init.php");
$title="LEP | Executive Board";
const max_size = 1000000;

$invalid=0;

//QUERY data for member chosen
if(isset($_POST["editform"]) && is_user_logged_in()){
  $value=filter_input(INPUT_POST, "currentid", FILTER_SANITIZE_STRING);
} else {
  $value = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
}
$params = array(
':eboardid' => $value
);
$sql="SELECT * FROM eboard WHERE id=:eboardid";
$output= exec_sql_query($db, $sql, $params);
$records =$output->fetchAll();
$record= $records[0];

function getextension($id){
  global $db;
  $params = array(
      ':id' => $id
  );
  $sql="SELECT * FROM eboard
  WHERE id=:id";
  $output= exec_sql_query($db, $sql, $params);
  $records =$output->fetchAll();
  return $records[0]["extension"];
}

if(isset($_POST["editform"]) && is_user_logged_in()){ //if the edit form is submitted
  $image_ext= filter_input(INPUT_POST, "exten", FILTER_SANITIZE_STRING);
  $current_id=filter_input(INPUT_POST, "currentid", FILTER_SANITIZE_STRING);
  $upload= is_uploaded_file($_FILES["editpic"]["tmp_name"]);
  if($upload){
    $edit_image = $_FILES["editpic"];
  }

  if(!isset($edit_image)||$edit_image['error']==UPLOAD_ERR_OK){
    $db->beginTransaction();
    if($upload){
      $old_path = "uploads/eboard/".$current_id.".".$image_ext."";
      unlink($old_path);
      $image_name=basename($edit_image["name"]);
      $extension = strtolower( pathinfo($image_name, PATHINFO_EXTENSION) );
    } else {
      $extension= $image_ext;
    }
    $editname=filter_input(INPUT_POST, "editname", FILTER_SANITIZE_STRING);
    $editposition=filter_input(INPUT_POST, "editposition", FILTER_SANITIZE_STRING);
    $editintro=filter_input(INPUT_POST, "editintro", FILTER_SANITIZE_STRING);

    if($editname=="" || $editposition=="" || $editintro==""){
      $invalid=1;
    } else {
      $sql ="UPDATE eboard SET position = :position, name = :name, bio=:bio, extension=:extension WHERE id=:id";
      $params = array(
        ':position'=>$editposition,
        ':name' => $editname,
        ':bio' => $editintro,
        ':extension' => $extension,
        ':id' => $current_id
      );
      $results = exec_sql_query($db, $sql, $params)->fetchAll();
      if($upload){
        $new_path = "uploads/eboard/".$current_id.".".$extension."";
        move_uploaded_file( $edit_image["tmp_name"], $new_path );
      }
    }
    $db->commit();
  }
  else{
    $invalid=1;
  }
}

//delete event
if(isset($_GET['rem_rel']) && is_user_logged_in()){
  $id = filter_input(INPUT_GET, 'rem_rel', FILTER_SANITIZE_NUMBER_INT);
  $sql = "DELETE FROM eboard_events WHERE id = :id;";
  $params = array(
    ':id' => $id
  );
  exec_sql_query($db, $sql, $params);
}
//delete member
if (isset($_GET["delete"]) && is_user_logged_in()){
  $db->beginTransaction();
  $value=filter_input(INPUT_GET, "delete", FILTER_SANITIZE_NUMBER_INT);
  $params = array(
      ':memberid' => $value
  );
  $extension=getextension($value);
  $sql="DELETE FROM eboard WHERE id=:memberid";
  $output= exec_sql_query($db, $sql, $params);
  $new_path = "uploads/eboard/".$value.".".$extension."";
  unlink($new_path);
  $params = array(
    ':memberid' => $value
  );
  $sql ="DELETE FROM eboard_events WHERE eboard_id=:memberid";
  $output= exec_sql_query($db, $sql, $params);
  $db->commit();
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
          <section class="gallery">

            <?php if(!isset($_GET["edit"])&&!isset($_GET["delete"])&&isset($_GET["id"])){ ?>
            <div class="EboardMember">

              <img class="profilepic" src="uploads/eboard/<?php echo htmlspecialchars($record["id"]).".".htmlspecialchars($record["extension"]); ?>" alt="<?php echo htmlspecialchars($record["name"]); ?>">

              <?php if($record["id"]<=3) { ?>

                <!-- Source: http://orgsync.rso.cornell.edu/org/lep/meettheboard-->
                <cite>Source: <a href='http://orgsync.rso.cornell.edu/org/lep/meettheboard'>Cornell LEP</a></cite>

              <?php } ?>
              <p class="eb_info"> Name: <?php echo htmlspecialchars($record["name"]); ?></p>
              <p class="eb_info">Position: <?php echo htmlspecialchars($record["position"]); ?></p>
              <h2 class="quote_left">"</h2>
              <p><?php echo htmlspecialchars($record["bio"]); ?>  </p>

              <h2 class="quote_right">"</h2>

              <?php
                $id_eb=$record["id"];
                $params = array(
                  ':eboard_id' => $id_eb
                );
                $sql= "SELECT title, eboard_events.id AS id FROM events INNER JOIN eboard_events ON event_id= events.id WHERE eboard_id=:eboard_id";
                $output= exec_sql_query($db, $sql, $params);
                $rels_eb = $output->fetchAll();
              ?>

              <?php if (sizeof($rels_eb)!=0){?>
                <p><strong> Events in charge of: </strong><?php if(is_user_logged_in()){ echo "Click [x] to remove an event"; }?></p>

                <div>
                  <?php
                    foreach($rels_eb as $rel_eb){
                      if (is_user_logged_in()){
                        ?>
                        <p><?php echo htmlspecialchars($rel_eb['title']) ?> [<a href="<?php echo 'member.php?'.http_build_query(array('rem_rel'=>htmlspecialchars($rel_eb["id"]), 'id'=>htmlspecialchars($record["id"]))) ?>">x</a>]</p>
                        <?php
                      } else {?>
                        <p class="centered"><?php echo htmlspecialchars($rel_eb['title']) ?></p>
                        <?php
                      }
                    }
                  ?>
                </div>
              <?php } ?>

              <?php if (is_user_logged_in()){ ?>
              <div id="eBoardEditButtons">
                <a class="button" href="<?php echo 'member.php?'.http_build_query(array('delete'=>htmlspecialchars($record["id"]), 'id'=>htmlspecialchars($record["id"]))) ?>">Delete </a>
                <a class="button" href="<?php echo 'member.php?'.http_build_query(array('id'=>htmlspecialchars($record["id"]), 'edit'=>htmlspecialchars($record["id"]))) ?>">Edit</a>
              </div>
              <?php } ?>
              <?php } elseif(isset($_GET["delete"])) {?>
              <div class="centered">
                <h1> The member was successfully deleted! </h1>

                <!-- Source: https://www.google.com/search?biw=1372&bih=684&tbm=isch&sa=1&ei=G3fQXL3pGdLk_AbjwaXABA&q=dog+wink&oq=dog+wink&gs_l=img.3..0l4j0i5i30l2j0i8i30l4.17057.18075..18220...0.0..0.114.705.4j4......1....1..gws-wiz-img.......35i39j0i67.8O3Ja3SExbI#imgrc=7Vi1BJVRSCiEJM:-->
                <img class="dogpic" src='images/dog_wink.jpg' alt="dog winks" id="wink"><br/>
                <cite>Source: <a href='https://www.google.com/search?biw=1372&bih=684&tbm=isch&sa=1&ei=G3fQXL3pGdLk_AbjwaXABA&q=dog+wink&oq=dog+wink&gs_l=img.3..0l4j0i5i30l2j0i8i30l4.17057.18075..18220...0.0..0.114.705.4j4......1....1..gws-wiz-img.......35i39j0i67.8O3Ja3SExbI#imgrc=7Vi1BJVRSCiEJM:'>Google</a></cite>
              </div>

              <?php } else { ?>
              <img src="uploads/eboard/<?php echo htmlspecialchars($record["id"]).".".htmlspecialchars($record["extension"]); ?>" alt="<?php echo htmlspecialchars($record["name"]); ?>" class="profilepic">
              <?php if($record["id"]<=3) { ?>
                <!-- Source: http://orgsync.rso.cornell.edu/org/lep/meettheboard-->
                <cite class="members">Source: <a href='http://orgsync.rso.cornell.edu/org/lep/meettheboard'>Cornell LEP</a></cite>
                <?php } ?>
                <form id="edit-eboard-form" method="post" action="member.php" enctype="multipart/form-data">

                  <?php if($invalid==1){?>
                    <div class="error">
                      <p> There seems to be an error </p>
                    </div>
                  <?php } ?>
                  <ul>
                    <li>
                      <input type="hidden" name="exten" value="<?php echo htmlspecialchars($record["extension"]);?>">
                      <input type="hidden" name="currentid" value="<?php echo htmlspecialchars($record["id"]); ?>">
                      <input type="hidden" name="max_size" value="<?php echo max_size; ?>">
                      <label class="replace"> <strong>Replace Photo:</strong> </label>
                      <input type="file" name="editpic">
                    </li>

                    <li>
                      <label> <strong>Name:</strong> </label>
                      <input type="text" name="editname" value="<?php echo htmlspecialchars($record["name"]); ?>">
                    </li>

                    <li>
                      <label><strong> Position: </strong></label>
                      <input type="text" name="editposition" value="<?php echo htmlspecialchars($record["position"]); ?>">
                    </li>

                    <li>
                      <label class="below"> <strong>Introduction:</strong> </label>
                      <textarea rows="5" cols="70" name="editintro" ><?php echo htmlspecialchars($record["bio"]); ?></textarea>
                    </li>
                  </ul>

                  <a class="button" href="<?php echo 'member.php?'.http_build_query(array('id'=>htmlspecialchars($record["id"]))) ?>">View</a>

                  <button type="submit" class="button" name="editform"> <strong>Update</strong></button>
                </form>
            <?php } ?>
            <div>
              <a class="button right" href="eboard.php">Back to EBoard Page</a>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
  <?php include("includes/footer.php")?>
</body>
</html>
