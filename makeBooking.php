<?php
$bookingDate = $_GET["bookingDate"];
?>

<!doctype html>
<html>

  <head>
    <meta charset="UTF-8">
  	<title>Car Booking | Make Booking</title>
  	<link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" />
  	<script type="text/javascript" src="js/formValidation.js"></script>
  </head>

  <body>
    <div id="page">
      <?php include_once('includes/header.php'); ?>
      <?php include_once('includes/menu.php'); ?>
      <div id="content">
        <h1>Make a Booking</h1>
        <form name="bookingForm" method="post" action="insertBooking.php" class="my_form" onsubmit="return validateBookingForm()">
          <input type="hidden" name="bookingDate" value="<?php echo $bookingDate; ?>" />

          <label>Booking Date:</label>
          <input type="text" name="selectedDate" value="<?php echo $bookingDate; ?>" disabled />

          <label>Booking Time:</label>
          <select name="bookingTime">
            <option value="8:00:00">8:00</option>
            <option value="9:00:00">9:00</option>
            <option value="10:00:00">10:00</option>
            <option value="11:00:00">11:00</option>
            <option value="12:00:00">12:00</option>
            <option value="13:00:00">13:00</option>
            <option value="14:00:00">14:00</option>
            <option value="15:00:00">15:00</option>
          </select>

          <label>Reason:</label>
          <textarea name="bookingReason" id="bookingReason" cols="20" rows="5"></textarea>

          <input type="submit" class="button" value="Submit" />
        </form>
      </div> <!-- content -->
      <?php include_once('includes/footer.php'); ?>
    </div> <!-- page -->
  </body>

</html>