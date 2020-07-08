<?php
    include("includes/init.php");
     // INCLUDE ON EVERY TOP-LEVEL PAGE!

     $sources=["Photo is Property of Cornell's LEP"];

?>
<!DOCTYPE html>
<html lang="en">

<?php include("includes/head.php")?>

<body>
  <?php include("includes/header.php");?>
  <?php include("includes/finalref.php")?>

  <?php

        if (!(isset($_GET['search']))){
            $sql="SELECT * FROM images;";
            $params = array();
            $output= exec_sql_query($db, $sql, $params);
            $searchresults =$output->fetchAll();

        } else {
            $searchval= filter_input(INPUT_GET, "searchval", FILTER_SANITIZE_STRING);
            $params = array(
            ':searchval' => $searchval
            );
            $sql="SELECT * FROM images WHERE id IN (SELECT DISTINCT image_id FROM image_tags WHERE tag_id IN (SELECT id FROM tags WHERE tag_name LIKE '%' || :searchval || '%'))";
            $output= exec_sql_query($db, $sql, $params);
            $searchresults =$output->fetchAll();
        }



        if (isset($_POST["deletetag"]) && is_user_logged_in()){
            $value= filter_input(INPUT_POST, "deletetag", FILTER_SANITIZE_NUMBER_INT);
            $params = array(
            ':imagetag' => $value
            );
            $sql="SELECT user_id FROM images WHERE id IN (SELECT DISTINCT image_id FROM image_tags WHERE id=:imagetag)";
            $output= exec_sql_query($db, $sql, $params)->fetchAll();
            $tag_user =$output[0][0];
            $curr_user= $current_user['id'];
            if($tag_user==$curr_user){
                $params = array(
                ':deletetag' => $value
                );
                $sql="DELETE FROM image_tags WHERE id=:deletetag";
                $output= exec_sql_query($db, $sql, $params);
                $records =$output->fetchAll();
            }
        }

        if (isset($_POST["confirmchanges"])) {
            $includetag = filter_input(INPUT_POST, "includetag", FILTER_SANITIZE_STRING);
            if ($includetag!="default"){
                $sql = "SELECT id FROM tags WHERE id IN (SELECT tag_id FROM image_tags WHERE image_id=:id)";
                $imageid= filter_input(INPUT_POST, "confirmchanges", FILTER_SANITIZE_NUMBER_INT);
                $params = array(
                    ':id' => $imageid
                );
                $inccomplx = exec_sql_query($db, $sql, $params)->fetchAll();
                $incnames = array_column($inccomplx, "id");
                $value=$_POST["includetag"];
                if(!in_array($value, $incnames)){
                    $imageid= filter_input(INPUT_POST, "confirmchanges", FILTER_SANITIZE_NUMBER_INT);
                    $params = array(
                    ':includetag' => $value,
                    ':imageid' => $imageid
                    );
                    $sql="INSERT INTO 'image_tags'(tag_id, image_id) VALUES (:includetag, :imageid);";
                    $output= exec_sql_query($db, $sql, $params);
                    $records =$output->fetchAll();
                }
            }

            if(isset($_POST["insertnew"]) && $_POST["insertnew"]!=""){


                $newtag = strtolower(filter_input(INPUT_POST, "insertnew", FILTER_SANITIZE_STRING));
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
                    $id_image= filter_input(INPUT_POST, "confirmchanges", FILTER_SANITIZE_NUMBER_INT);
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





        if (isset($_POST["allimages"])){
            $params = array();
            $sql="SELECT * FROM images";
            $output= exec_sql_query($db, $sql, $params);
            $records =$output->fetchAll();
        }

        $params = array();
        $sql="SELECT * FROM tags";
        $output= exec_sql_query($db, $sql, $params);
        $tags = $output->fetchAll();


        ?>

  <main>

    <div class="content-wrap">
      <article class="content">
        <section id="ImgSearch">
            <h1> Find Images </h1>

            <form method="get" action="images.php">
                <fieldset>
                    <p>
                    <label id="searchlbl"> Search Below: </label>
                    <input type="text" id="searchimg" placeholder="Search by Tag" name="searchval">
                    <button type="submit" name="search" value="Search" class="submitbtn">Search </button>
                    </p>
                </fieldset>
            </form>
            <form method="get" action="images.php">
                <button type="submit" name="allimages" value="allimages" class="submitbtn" id="allimages">All Images </button>
            </form>

        </section>
        <section class="allimages">
            <?php
                foreach($searchresults as $searchresult){
                    image_details($searchresult);
                }
            ?>
        </section>
      </article>
    </div>



  </main>

  <!-- TODO: This should be your main page for your site. -->

</body>
</html>
