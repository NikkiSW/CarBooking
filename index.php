<!doctype html>
<html>

  <head>
    <meta charset="UTF-8">
  	<title>Car Booking</title>
  	<link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" />
  </head>

  <body>
    <div id="page">
      <?php include_once('includes/header.php'); ?>
      <?php include_once('includes/menu.php'); ?>
      <div id="content">
        <h1>Welcome to the Company Car Booking System</h1>
        <?php
        if (isset($_SESSION["userId"])) {
          echo "You are currently logged in. Feel free to make use of one of the available menu items.";
        } // if
        else {
          echo "Please <a href='login.php'>login</a> to access this system.";
        } // else
        ?>
      </div> <!-- content -->
      <?php include_once('includes/footer.php'); ?>
    </div> <!-- page -->
  </body>

</html>