<?php
require_once("config/db.php");
session_start();

$db = new Database();
$bookingDate = $_POST["bookingDate"];
$bookingTime = $_POST["bookingTime"];
$userId = $_SESSION["userId"];
$bookingReason = $_POST["bookingReason"];

$query  = "INSERT INTO booking ";
$query .= "(booked_date, booked_time, user_id, reason, km_recorded) ";
$query .= "VALUES ";
$query .= "('".$bookingDate."', '".$bookingTime."', ".$userId.", '".$bookingReason."', 0) ";

$result = $db->query($query);

if ($result['success'] == false) {
  die ("A database error has occurred: " . $result['error']);
}

// Send admin email
$query  = "SELECT email ";
$query .= "FROM user ";
$query .= "WHERE role_id = 1 ";

$result = $db->query($query);

if ($result['success'] == false) {
  die ("A database error has occurred: " . $result['error']);
} //if

if ($result['count'] == 1) {
  $adminEmail = $result['rows'][0]['email'];
} // if

$subject = "New Company Car Booking";
$to = $adminEmail;
$body = "The company car has been booked for ".$bookingDate." at ".$bookingTime."\n\nBooking reason:\n".$bookingReason;
$ok = @mail($to, $subject, $body);

if ($ok) {
  $adminMailResult = 1;
} else {
  $adminMailResult = 0;
}

// Send user email
$query  = "SELECT email ";
$query .= "FROM user ";
$query .= "WHERE id = " . $userId . " ";

$result = $db->query($query);

if ($result['success'] == false) {
  die ("A database error has occurred: " . $result['error']);
}

print_r($result);
echo $result['rows'][0]['email'] . "<br>";

if ($result['count'] == 1) {
  $userEmail = $result['rows'][0]['email'];
}

$subject = "New Company Car Booking";
$to = $userEmail;
$body = "You have booked the company car for ".$bookingDate." at ".$bookingTime."\n\nBooking reason:\n".$bookingReason;
$ok = @mail( $to, $subject, $body );

if ($ok) {
  $userMailResult = 1;
} else {
  $userMailResult = 0;
}

header("location:bookingAdded.php?userEmail=".$userEmail."&adminMailResult=".$adminMailResult."&userMailResult=".$userMailResult);
?>