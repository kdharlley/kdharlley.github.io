<?php
include("includes/init.php");
$title = "LEP | Listserv Requests";
//print table of listserv records
function print_record_listerv($records) {
  ?>
  <table id="positions">
  <tr>
    <th>Name</th>
    <th>Email</th>
    <th>Class</th>
    <th>Languages Spoken</th>
    <th>Languages to Practice</th>
    <th> </th>
  </tr>
  <?php foreach($records as $record) { ?>
  <tr>
    <td><?php echo htmlspecialchars($record["fullname"]);?></td>
    <td><?php echo htmlspecialchars($record["email"]);?></td>
    <td><?php echo htmlspecialchars($record["class"]);?></td>
    <td><?php echo htmlspecialchars($record["speak"]);?></td>
    <td><?php echo htmlspecialchars($record["practice"]);?></td>
    <td><a class="button" href="<?php echo 'listervapps.php?'.http_build_query(array('delete'=>htmlspecialchars($record["id"]), 'id'=>htmlspecialchars($record["id"]))) ?>">Delete</a>  </td>
  </tr>
  <?php } ?>
  </table>
<?php }

//delete listserv entry
if (isset($_GET["delete"])){
  $value=filter_input(INPUT_GET, "delete", FILTER_SANITIZE_NUMBER_INT);
  $params = array(
      ':l_id' => $value
  );
  $sql="DELETE FROM listerv WHERE id=:l_id";
  $output= exec_sql_query($db, $sql, $params);
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
          <h3> All listerv requests are displayed below. </h3>
          <?php
            $sql="SELECT * FROM listerv";
            $results=exec_sql_query($db,$sql,array())->fetchAll(PDO::FETCH_ASSOC);

            print_record_listerv($results);
          ?>
          <a class="button right" href="join.php">Back to Join Us Page</a>
        </div>
      </div>
    </div>
  </div>
  <?php include("includes/footer.php")?>
</body>
</html>
