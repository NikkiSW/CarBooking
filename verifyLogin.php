<?php
require_once("config/db.php");
$db = new Database();
session_start();

$username = $_POST["username"];
$password = $_POST["password"];

$query  = "SELECT id ";
$query .= "FROM user ";
$query .= "WHERE username = '" . $username ."' AND password = MD5('" . $password ."') ";

$result = $db->query($query);

if ($result['success'] == false) {
  die ("A database error has occurred: " . $result['error']);
} //if

if ($result['count'] == 1) {
  list($userId) = $result['rows'][0]['id'];
  $_SESSION["userId"] = $userId;
  header("location:viewCalendar.php");
} // if
else {
  header("location:login.php?failedLogin=1");
} // else
?>