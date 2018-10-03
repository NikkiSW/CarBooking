<?php
$kmRecorded = $_GET["kmRecorded"];
$bookingId = $_GET["bookingId"];

require_once("config/db.php");

$db = new Database();

$query  = "UPDATE booking ";
$query .= "SET km_recorded = " . $kmRecorded. " ";
$query .= "WHERE id = " . $bookingId . " ";

$result = $db->query($query);
?>

<!doctype html>
<html>

  <head>
    <meta charset="UTF-8">
  	<title>Car Booking | KMs Updated</title>
  	<link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" />
  </head>

  <body>
    <div id="page">
      <?php include_once('includes/header.php'); ?>
      <?php include_once('includes/menu.php'); ?>
      <div id="content">
        <div class="notice"><b>You have successfully recorded your kilometres travelled!</b></div>
      </div> <!-- content -->
      <?php include_once('includes/footer.php'); ?>
    </div> <!-- page -->
  </body>

</html>