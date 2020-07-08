<?php
    include("includes/init.php");
     // INCLUDE ON EVERY TOP-LEVEL PAGE!

?>
<!DOCTYPE html>
<html lang="en">

<?php include("includes/head.php")?>

<body>
  <?php include("includes/header.php");?>
  <?php include("includes/finalref.php")?>

  <?php
        $showinfo=TRUE;
        if (isset($_GET["id"])){
            $value = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            $params = array(
            ':viewimage' => $value
            );
            $sql="SELECT * FROM images
            WHERE id=:viewimage";
            $output= exec_sql_query($db, $sql, $params);
            $records =$output->fetchAll();
        }


        if (isset($_GET["deletebutton"])&& is_user_logged_in()){
            $value=filter_input(INPUT_GET, "deletebutton", FILTER_SANITIZE_NUMBER_INT);
            $params = array(
                ':imageid' => $value
            );
            $sql="SELECT user_id FROM images WHERE id=:imageid";
            $output= exec_sql_query($db, $sql, $params)->fetchAll();
            $tag_user =$output[0][0];
            $curr_user= $current_user['id'];
            $showinfo=$tag_user==$curr_user;
            if($tag_user==$curr_user){
                $params = array(
                ':deleteimage' => $value
                );
                $extension=getextension($value);
                $sql="DELETE FROM images WHERE id=:deleteimage";
                $output= exec_sql_query($db, $sql, $params);
                $new_path = "uploads/images/".$value.".".$extension."";
                unlink($new_path);
                $params = array(
                ':deleteimage' => $value
                );
                $sql ="DELETE FROM image_tags WHERE image_id=:deleteimage";
                $output= exec_sql_query($db, $sql, $params);
            }
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
            <?php if (isset($_GET["id"])){
            ?>
            <h1> View the Animal Below</h1>
            <p> View the animal you selected below </p>

            <?php } elseif (isset($_GET["deletebutton"]) && $showinfo && is_user_logged_in()) { ?>

            <h1> Thank you for updating our Library</h1>
            <p> The updated library with the deleted animal removed can be seen if you click on the images tab. <a href="images.php">Go Back </a> </p>


            <?php
            } else {
            ?>
            <h1> Oops there was a problem</h1>
            <p>We seem to have run into a problem please go back to the homepage, this could be because you dont have permission to perform the selected action. <a href="images.php">Go Back </a>  </p>

            <?php
            }
            ?>
        </section>
        <?php if (isset($_GET["id"])){
        ?>
        <section class="allimages">
            <?php
                image_details($records[0]);
            ?>
        </section>
        <?php
        }
        ?>

      </article>
    </div>

  </main>
  <!-- TODO: This should be your main page for your site. -->

</body>
</html>
