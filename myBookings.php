<!doctype html>
<html>

  <head>
    <meta charset="UTF-8">
  	<title>Car Booking | My Bookings</title>
  	<link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" />
  </head>

  <body>
    <div id="page">
      <?php include_once('includes/header.php'); ?>
      <?php include_once('includes/menu.php'); ?>

      <?php
      if (isset($_SESSION["userId"])) {
        require_once("config/db.php");
		
		$db = new Database();

        $userId = $_SESSION["userId"];

        $query  = "SELECT b.id, b.booked_date, b.booked_time, u.first_name, u.last_name ";
        $query .= "FROM booking b ";
        $query .= "INNER JOIN user u ";
        $query .= "ON b.user_id = u.id ";
        $query .= "WHERE b.user_id = " . $userId . " ";
        $query .= "ORDER BY b.booked_date ASC ";
        $result = $db->query($query);
        $bookingArr = array();

        if ($result['success'] == true) {
		  $bookingArr = $result['rows'];
	    } else {
		  echo "A database error has occurred.";
	    } //if
      }
      ?>

      <div id="content">
        <?php
        if (isset($_SESSION["userId"])) {
        ?>
          <h1>My Bookings</h1>
          <?php
          while (list($index) = each($bookingArr)) {
            echo $bookingArr[$index]["first_name"] . "&nbsp;" . $bookingArr[$index]["last_name"] . "&nbsp;" . $bookingArr[$index]["booked_date"] . "&nbsp;" . $bookingArr[$index]["booked_time"] . "&nbsp;<a href='viewBooking.php?bookingId=" . $bookingArr[$index]["id"] . "'>View Booking</a><br />";
          }
          ?>
        <?php
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