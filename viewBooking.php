<?php
require_once("config/db.php");

$db = new Database();

$bookingId = $_GET["bookingId"];

$query  = "SELECT b.user_id, u.first_name, u.last_name, b.booked_date, b.booked_time, b.reason, b.km_recorded ";
$query .= "FROM user u ";
$query .= "INNER JOIN booking b ";
$query .= "ON u.id = b.user_id ";
$query .= "WHERE b.id = " . $bookingId. " ";

$result = $db->query($query);
$bookingInfo = array();
if ($result['success'] == true) {
  $bookingInfo = $result['rows'][0];
} else {
  echo "A database error has occurred.";
} //if

$today = date('Y-m-d');
?>

<!doctype html>
<html>

  <head>
    <meta charset="UTF-8">
  	<title>Car Booking | View Booking</title>
  	<link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" />
  </head>

  <body>
    <div id="page">
      <?php include_once('includes/header.php'); ?>
      <?php include_once('includes/menu.php'); ?>
      <div id="content">
        <form class="my_form">

          <label>First Name:</label>
          <input type="text" name="firstName" value="<?php echo $bookingInfo["first_name"]; ?>" disabled />

          <label>Last Name:</label>
          <input type="text" name="lastName" value="<?php echo $bookingInfo["last_name"]; ?>" disabled />

          <label>Booked Date:</label>
          <input type="text" name="bookedDate" value="<?php echo $bookingInfo["booked_date"]; ?>" disabled />

          <label>Booked Time:</label>
          <input type="text" name="bookedTime" value="<?php echo $bookingInfo["booked_time"]; ?>" disabled />

          <label>Reason:</label>
          <textarea name="reason" cols="20" rows="5" disabled><?php echo $bookingInfo["reason"]; ?></textarea>

          <?php
          // The km recorded box will only be displayed if the booked date is less than or equal to today
          if ($bookingInfo["booked_date"] <= $today) {

            // If the logged in user is viewing their own booking and have not yet recorded their kms, the text field should be enabled
            if (($_SESSION["userId"] == $bookingInfo["user_id"]) && ($bookingInfo["km_recorded"] == "0")) {
              $editFlag = "";
            } // if

            // If the logged in user is viewing someone else's booking OR the kms have already been recorded, the text field should be disabled
            else if (($_SESSION["userId"] != $bookingInfo["user_id"]) || ($bookingInfo["km_recorded"] != "0")) {
              $editFlag = "disabled";
            }// else if
            ?>
            <label>Recorded KM:</label>
            <input type="text" name="kmRecorded" value="<?php echo $bookingInfo["km_recorded"]; ?>" <?php echo $editFlag; ?> />
            <?php

            // If user is able to edit their km, show submit button
            if ($editFlag == "") {
              ?>
              <input type="button" class="button" value="Insert KM" onclick="window.location='updateKm.php?bookingId=<?php echo $bookingId; ?>&kmRecorded='+kmRecorded.value" />
              <?php
            }
          } // if

          // If the logged in user is view their own booking and the booked date is greater than today, show cancel booking button
          if (($_SESSION["userId"] == $bookingInfo["user_id"]) && ($bookingInfo["booked_date"] > $today)) {
            ?>
            <input type="button" class="button" value="Cancel Booking" onclick="window.location='cancelBooking.php?bookingId=<?php echo $bookingId; ?>&userId=<?php echo $bookingInfo["user_id"]; ?>&bookedDate=<?php echo $bookingInfo["booked_date"]; ?>&bookedTime=<?php echo $bookingInfo["booked_time"]; ?>&firstName=<?php echo $bookingInfo["first_name"]; ?>&lastName=<?php echo $bookingInfo["last_name"]; ?>'" />
            <?php
          } // if
          ?>

        </form>
      </div> <!-- content -->
      <?php include_once('includes/footer.php'); ?>
    </div> <!-- page -->
  </body>

</html>