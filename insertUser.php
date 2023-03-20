<?php 

include 'sql.php';

$query = "INSERT INTO users (username, email, password, description, avatarimgpath, firstname, lastname) VALUES (?, ?, ?, ?, ?, ?, ?)";
$types = "sssssss";

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['pw'];
$description = 'test';
$avatarimgpath = 'images/'.$username.'/'.$_FILES['img'];
$firstname = $_POST['fname'];
$lastname = $_POST['lname'];

$result = php_insert($query, $types, $username, $email, $password, $description, $avatarimgpath, $firstname, $lastname);

if ($result) {
    echo "Insertion succeeded";
} else {
    echo "Insertion failed";
}

header("Location: index.php");
exit();

?>