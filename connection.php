<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "db_29957115";
$connection_sucess = false;

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} else {
  $connection_sucess = true;
}
?>