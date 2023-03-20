<?php 

include 'sql.php';

$query = "INSERT INTO users (username, email, password, description, avatarimgpath, firstname, lastname) VALUES (?, ?, ?, ?, ?, ?, ?)";
$types = "sssssss";

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['pw'];
$description = 'test';
$avatarimgpath = 'images/'.$username.'/'.$_FILES['img']['name'];
$firstname = $_POST['fname'];
$lastname = $_POST['lname'];

$result = php_insert($query, $types, $username, $email, $password, $description, $avatarimgpath, $firstname, $lastname);

if ($result) {
    if (!file_exists('images/'.$username)) {
        mkdir('images/'.$username, 0777, true);
    }
    move_uploaded_file($_FILES['img']['tmp_name'], $avatarimgpath);


    echo "Insertion succeeded";
} else {
    echo "Insertion failed";
}

header("Location: index.php");
exit();

?>