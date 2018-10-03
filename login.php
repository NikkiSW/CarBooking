<!doctype html>
<html>

  <head>
    <meta charset="UTF-8">
  	<title>Car Booking | Login</title>
  	<link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" />
  </head>

  <body>
    <div id="page">
      <?php include_once('includes/header.php'); ?>
      <?php include_once('includes/menu.php'); ?>
      <div id="content">
        <h1>Login</h1>
        <?php
        if (isset($_GET["failedLogin"])) {
          echo "<div class='error'>Incorrect username/password combination. Please try again.</div>";
        } // if

        if (isset($_GET["logout"])) {
          session_unset();
          session_destroy();
          echo "<div class='notice'>Thank you for using the Company Car Booking System</div>";
        } // if
        ?>
        <form name="loginForm" method="post" action="verifyLogin.php" class="my_form">
          <label>Username:</label>
          <input type="text" name="username" />
          <br />
          <label>Password:</label>
          <input type="password" name="password" />
          <br />
          <input type="submit" class="button" value="Submit" />
        </form>
      </div> <!-- content -->
      <?php include_once('includes/footer.php'); ?>
    </div> <!-- page -->
  </body>

</html>