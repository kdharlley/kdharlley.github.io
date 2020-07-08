<?php
 // INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");

const max_size = 1000000;

$params = array();
$sql="SELECT * FROM tags";
$output= exec_sql_query($db, $sql, $params);
$tags = $output->fetchAll();


function output_tags($tag){
    ?>
    <option value=<?php echo htmlspecialchars($tag["id"])?>> <?php echo htmlspecialchars($tag["tag_name"]) ?></option>
    <?php
}

?>
<!DOCTYPE html>
<html lang="en">

<?php include("includes/head.php")?>

<body>
  <?php include("includes/header.php");?>

  <main>

    <div class="content-wrap">
      <article class="content">
        <section id="IntroSect">
        <?php

          if(isset($_POST["submitform"]) && is_user_logged_in()){
            $inside="Made it in";
            $image_info = $_FILES["fileupload"];

            $bio = filter_input(INPUT_POST, "bio", FILTER_SANITIZE_STRING);
            $tagsselected= $_POST['tagsselected'];

            if($image_info['error']==UPLOAD_ERR_OK){
              $image_name=basename($image_info["name"]);
              $extension = strtolower( pathinfo($image_name, PATHINFO_EXTENSION) );
              $user_id=$current_user['id'];
              $sql = "INSERT INTO images(user_id, extension, bio) VALUES (:user_id, :extension, :bio);";
              $params = array(
                ':user_id' => $user_id,
                ':bio' => $bio,
                ':extension' => $extension
              );
              $results = exec_sql_query($db, $sql, $params)->fetchAll();
              $temp_name = $image_info["tmp_name"];
              $id_db=$db->lastInsertId();
              $new_path = "uploads/images/".$id_db.".".$extension."";
              move_uploaded_file( $image_info["tmp_name"], $new_path );
              foreach($tagsselected as $tagselected){
                $tagselected= filter_var($tagselected, FILTER_SANITIZE_STRING);
                $sql = "SELECT id FROM tags WHERE id IN (SELECT tag_id FROM image_tags WHERE image_id=:id)";
                $params = array(
                    ':id' => $id_db
                );
                $inccomplx = exec_sql_query($db, $sql, $params)->fetchAll();
                $incnames = array_column($inccomplx, "id");
                if(!in_array($tagselected, $incnames)){
                  $sql = "INSERT INTO image_tags(tag_id, image_id) VALUES (:tag_id, :image_id);";
                  $params = array(
                    ':tag_id' => $tagselected,
                    ':image_id' => $id_db
                  );
                  $output = exec_sql_query($db, $sql, $params)->fetchAll();
                }
              }

              if(isset($_POST["newtag"]) && !is_null($_POST["newtag"]) && $_POST["newtag"]!=""){
                $newtag = strtolower(filter_input(INPUT_POST, "newtag", FILTER_SANITIZE_STRING));
                $sql = "SELECT tag_name FROM tags";
                $params = array();
                $tagcomplx = exec_sql_query($db, $sql, $params)->fetchAll();
                $tagnames = array_column($tagcomplx, "tag_name");
                if(!in_array($newtag, $tagnames)){
                  $sql = "INSERT INTO tags(tag_name) VALUES (:newtag);";
                  $params = array(
                    ':newtag' => $newtag
                  );
                  $output = exec_sql_query($db, $sql, $params)->fetchAll();
                  $id_image=$id_db;
                  $id_tag=$db->lastInsertId();
                  $sql = "INSERT INTO image_tags(tag_id, image_id) VALUES (:tag_id, :image_id);";
                  $params = array(
                    ':tag_id' => $id_tag,
                    ':image_id' => $id_image
                  );
                  $output = exec_sql_query($db, $sql, $params)->fetchAll();
                }

            }


            }

          }
        ?>
          <h1> Upload An Image </h1>
          <p> You can upload an image below </p>
        </section>
        <section id="loginsect">
          <h1> Please input your details</h1>
          <form method="post" action="uploads.php" enctype="multipart/form-data">
            <fieldset>
              <p id="fileinput">
                <input type="hidden" name="max_size" value="<?php echo max_size; ?>">
                <label> File </label>
                <input type="file" name="fileupload">
              </p>

              <h4> Select tags to Include. (hold ctrl/cmd when picking to select multiple options) </h4>

              <p id="selecttags">
              <select multiple name="tagsselected[]">
                <?php
                  foreach($tags as $tag){
                    output_tags($tag);
                  }
                ?>
              </select>
              </p>

              <p>
                  <label> New Tag </label>
                  <input type="text" name="newtag">
              </p>

              <p>
                  <label> Bio </label>
                  <input type="text" name="bio">
              </p>

              <button type="submit" name="submitform" id="loginbtn"> Submit</button>
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
