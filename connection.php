<?php
$conn = null;
// Create connection
function makeConnection(){
  global $conn;
  $servername = "localhost";
  $username = "root";
  $password = "";
  $db = "db_29957115";
  $connection_sucess = false;
  $conn = new mysqli($servername, $username, $password, $db);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  } else {
    $connection_sucess = true;
  }
  return $conn;
}

function getConnection(){
  global $conn;
  if(!isset($conn)){
    $conn = makeConnection();
    return $conn;
  } else {
    return $conn;
  }
}
?>