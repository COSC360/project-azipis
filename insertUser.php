<?php 

include 'sql.php';

$query = "INSERT INTO users (username, email, password, description, avatarimgpath, firstname, lastname, isAdmin) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$types = "sssssssi";

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['pw'];
$description = 'Welcome to CareerCafe! You can add a description about yourself here by editing your settings.';
$avatarimgpath = 'images/'.$username.'/'.$_FILES['img']['name'];
$firstname = $_POST['fname'];
$lastname = $_POST['lname'];
$admin = 0;

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$result = php_insert($query, $types, $username, $email, $hashed_password, $description, $avatarimgpath, $firstname, $lastname, $admin);

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