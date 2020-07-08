<?php
  include("includes/init.php");
  $title = "LEP | Delete Open Positions";

  // display positions in a table
  function print_record_positions2($record) {
    ?>
    <tr>
      <td><?php echo htmlspecialchars($record["title"]);?></td>
      <td class="centered"><a class="link" href="<?php echo 'delete_position.php?'.http_build_query(array('delete'=>htmlspecialchars($record["id"]), 'id'=>htmlspecialchars($record["id"]))) ?>">Delete</a>  </td>
    </tr>
    <?php
  }

  if (isset($_GET["delete"])){
    $db->beginTransaction(); // transaction required since some of the steps rely on previous ones executing properly

      $value=filter_input(INPUT_GET, "delete", FILTER_SANITIZE_NUMBER_INT);
      $sql="DELETE FROM positions WHERE id=:posid";
      $params = array(
          ':posid' => $value
      );
      $output= exec_sql_query($db, $sql, $params);

      $sql="DELETE FROM responsibilities WHERE position_id=:posid";
      $params = array(
          ':posid' => $value
      );
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
    <div class='main'>
      <?php include("includes/navigation_bar.php")?>
      <div class="right_side">
        <div class="main_content">

          <h3> Remove an Open Position </h3>

          <?php
            $pos = exec_sql_query($db, "SELECT * FROM positions", array())->fetchAll(PDO::FETCH_ASSOC);
            echo "<table id='positions'> <tr>
            <th>Position</th>
            <th>Action</th>
            </tr>";

            foreach($pos as $p_record) {
            print_record_positions2($p_record);
            }
            echo "</table>";
          ?>

          <a class="button right" href="join.php">Back to Join Us Page</a>

        </div>
      </div>
    </div>
  </div>

  <?php include("includes/footer.php")?>

</body>
</html>
