<?php
$bookingId = $_GET["bookingId"];
$bookedDate = $_GET["bookedDate"];
$bookedTime = $_GET["bookedTime"];
$userId = $_GET["userId"];
$firstName = $_GET["firstName"];
$lastName = $_GET["lastName"];

require_once("config/db.php");
$db = new Database();

$query  = "DELETE FROM booking ";
$query .= "WHERE id = " . $bookingId . " ";
$query .= "LIMIT 1 ";

$result = $db->query($query);

if ($result['success'] == false) {
  die ("A database error has occurred: " . $result['error']);
} else {
	// Send admin email
	$query  = "SELECT email ";
	$query .= "FROM user ";
	$query .= "WHERE role_id = 1 ";

	$result = $db->query($query);

	if ($result['success'] == false) {
		die ("A database error has occurred: " . $result['error']);
	}

	if ($result['count'] == 1) {
		$adminEmail = $result['rows'][0]['email'];
		$subject = "Company Car Booking Cancelled";
		$to = $adminEmail;
		$body = $firstName . " ". $lastName . " has cancelled the company car booking for " . $bookedDate . " at " . $bookedTime . ".";
		$ok = @mail($to, $subject, $body);

		if ($ok) {
			$adminMailResult = 1;
		} else {
			$adminMailResult = 0;
		}
	}

	// Send user email
	$query  = "SELECT email ";
	$query .= "FROM user ";
	$query .= "WHERE id = " . $userId . " ";

	$result = $db->query($query);

	if ($result['success'] == false) {
		die ("A database error has occurred: " . $result['error']);
	} else {
		if ($result['count'] == 1) {
			$userEmail = $result['rows'][0]['email'];
			$subject = "Company Car Booking Cancelled";
			$to = $userEmail;
			$body = "You have cancelled your company car booking for ".$bookedDate." at ".$bookedTime.".";
			$ok = @mail($to, $subject, $body);

			if ($ok) {
				$userMailResult = 1;
			} else {
				$userMailResult = 0;
			}
		}
	}
}

header("location:bookingCancelled.php?userEmail=".$userEmail."&adminMailResult=".$adminMailResult."&userMailResult=".$userMailResult);
?>