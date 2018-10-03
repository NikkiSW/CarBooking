<?php
session_start();
?>

<div id="header">
  <a href="index.php"><span class="logo">Company<b>Car</b>Booking</span></a>
  <?php
  if (isset($_SESSION["userId"])) {
    echo "<a class='header_link' href='login.php?logout=1'>Logout</a>";
  } // if
  else {
    echo "<a class='header_link' href='login.php'>Login</a>";
  } // else
  ?>
</div> <!-- header -->