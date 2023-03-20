<?php 

include 'connection.php';


$conn = getConnection();

$stmt = $conn->prepare("INSERT INTO users (username, email, password, description, avatarimgpath, firstname, lastname) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $username, $email, $password, $description, $avatarimgpath, $firstname, $lastname);

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['pw'];
$description = 'test';
$avatarimgpath = 'images/'.$username.'/'.$_FILES['img'];
$firstname = $_POST['fname'];
$lastname = $_POST['lname'];

echo $avatarimgpath;

$stmt -> execute();

echo "Account created";

$stmt->close();
$conn->close();

header("Redirect: index.php");
exit();

?>