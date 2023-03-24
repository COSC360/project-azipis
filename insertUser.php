<?php 

include 'sql.php';
include 'security.php';

$query = "INSERT INTO users (username, email, password, description, avatarimgpath, firstname, lastname, isAdmin) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$types = "sssssssi";

$username = get_sanitized_string_param($_POST,'username');
$email = get_sanitized_string_param($_POST,'email');
$password = get_sanitized_string_param($_POST,'pw');
$description = 'Welcome to CareerCafe! You can add a description about yourself here by editing your settings.';
$avatarimgpath = 'images/'.$username.'/'.$_FILES['img']['name'];
$firstname = get_sanitized_string_param($_POST,'fname');
$lastname = get_sanitized_string_param($_POST,'lname');
$admin = 0;

if(strlen($username) < 3 || strlen($username) > 20){
    header("Location: createAccount.php");
    die();
}

if(strlen($email) < 3 || strlen($email) > 100){
    header("Location: createAccount.php");
    die();
}

if(strlen($password) < 6 || strlen($password) > 1000){
    header("Location: createAccount.php");
    die();
}

if(strlen($firstname) < 1 || strlen($firstname) > 100){
    header("Location: createAccount.php");
    die();
}

if(strlen($lastname) < 1 || strlen($lastname) > 100){
    header("Location: createAccount.php");
    die();
}

if(!isset($_FILES['img']['name'])){
    header("Location: createAccount.php");
    die();
}

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