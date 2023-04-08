<?php 

error_reporting(E_ALL);
ini_set('display_errors', '1');


include 'functions.php';

$query = "INSERT INTO users (username, email, password, description, avatarimgpath, firstname, lastname, isAdmin) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$types = "sssssssi";

$username = get_non_html_sanitized_string_param($_POST,'username');
$email = get_non_html_sanitized_string_param($_POST,'email');
if(isset($_POST['pw'])){
    $password = $_POST['pw'];
} else {
    die("You must enter a password!");
}
$description = 'Welcome to CareerCafe! You can add a description about yourself here by editing your settings.';
$avatarimgpath = 'images/'.$username.'/'.$_FILES['img']['name'];
$firstname = get_non_html_sanitized_string_param($_POST,'fname');
$lastname = get_non_html_sanitized_string_param($_POST,'lname');
$admin = 0;

if(strlen($username) < 3 || strlen($username) > 20){
    //header("Location: createAccount.php");
    die("Invalid username!");
}

if(strlen($email) < 3 || strlen($email) > 100){
    //header("Location: createAccount.php");
    die("Email must be between 3 and 100 characters!");
}

if(strlen($password) < 6 || strlen($password) > 1000){
    //header("Location: createAccount.php");
    die("Password must be between 6 and 1000 characters!");
}

if(strlen($firstname) < 1 || strlen($firstname) > 100){
    //header("Location: createAccount.php");
    die("First name must be between 1 and 100 characters!");
}

if(strlen($lastname) < 1 || strlen($lastname) > 100){
    //header("Location: createAccount.php");
    die("Last name must be between 1 and 100 characters!");
}

if(!isset($_FILES['img']['name'])){
    //header("Location: createAccount.php");
    die("You must upload an image!");
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
    $conn = getConnection();
    echo "Insertion failed";
    mysqli_close($conn);
}

header("Location: index.php");
exit();

?>