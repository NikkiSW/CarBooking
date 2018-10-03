<?php
$userEmail = $_GET["userEmail"];
$adminMailResult = $_GET["adminMailResult"];
$userMailResult = $_GET["userMailResult"];
?>

<!doctype html>
<html>

  <head>
    <meta charset="UTF-8">
  	<title>Car Booking | Booking Cancelled</title>
  	<link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" />
  </head>

  <body>
    <div id="page">
      <?php include_once('includes/header.php'); ?>
      <?php include_once('includes/menu.php'); ?>
      <div id="content">
        <?php
        if ($adminMailResult == 1) {
          echo "<div class='notice'>Mail sent succesfully to system administrator</div>";
        } // if
        else {
          echo "<div class='error'>There was an error sending mail to the system administrator</div>";
        }

        if ($userMailResult == 1) {
          echo "<div class='notice'>An email confirming your cancellation has been sent to ".$userEmail."</div>";
        } // if
        else {
          echo "<div class='error'>There was an error sending the confirmation email to your address: ".$userEmail."</div>";
        }
        ?>
        <br />
        <br />
        <div class="notice"><b>You have successfully cancelled your company car booking</b></div>
      </div> <!-- content -->
      <?php include_once('includes/footer.php'); ?>
    </div> <!-- page -->
  </body>

</html>