<!doctype html>
<html>

  <head>
    <meta charset="UTF-8">
  	<title>Car Booking | View Calendar</title>
  	<link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" />
  	<link rel="stylesheet" href="css/calendar_stylesheet.css" type="text/css" media="screen" />
  </head>

  <body>
    <div id="page">
      <?php include_once('includes/header.php'); ?>
      <?php include_once('includes/menu.php'); ?>
      <div id="content">
        <?php
        // Checked that user is logged in and may access this page
        if (isset($_SESSION["userId"])) {
          require_once('includes/calendar.php');

          if (isset($_GET["navMonth"])) {
            $month = $_GET["navMonth"];
            $year = $_GET["navYear"];
          } // if
          else {
            $month = date('m');
            $year = date('Y');
          } // else
          renderCalendar($month, $year);
        } // if
        else {
          echo "You are not authorised to view this page. Please <a href='login.php'>login</a>.";
        } // else
        ?>
      </div> <!-- content -->
      <?php include_once('includes/footer.php'); ?>
    </div> <!-- page -->
  </body>

</html>