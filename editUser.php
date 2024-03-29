<?php

session_start();

include 'functions.php';

$column = get_sanitized_string_param($_POST, "column");
$value = get_sanitized_string_param($_POST,"value");
$userid = get_sanitized_int_param($_POST, "userid");
$username = get_sanitized_string_param($_POST, "username");

// if updated field is an image
if ($column === 'avatarimgpath'){



    $avatarimgpath = 'images/'.$username.'/'.$_FILES['img']['name'];


    $updateQuery = 'UPDATE users SET ' .$column. '= ? WHERE userid = ?;';
    $types = 'si';
    $result = php_update($updateQuery, $types, $avatarimgpath, $userid);


    if ($result) {
        if (!file_exists('images/'.$username)) {
            mkdir('images/'.$username, 0777, true);
        }
        move_uploaded_file($_FILES['img']['tmp_name'], $avatarimgpath);
    }

    if ($_SESSION['username'] === $username){
        $_SESSION[$column] = $avatarimgpath;
    }

    echo $result;


} else {

    if ($column === 'password'){

        if(strlen($value) < 6 || strlen($value) > 1000){
            header("Location: user.php?=". $_SESSION['username']);
            die();
        }

        $value = password_hash($value, PASSWORD_DEFAULT);
    }
    
    
    $updateQuery = 'UPDATE users SET ' .$column. '= ? WHERE userid = ?;';
    $types = 'si';
    $updateSuccess = php_update($updateQuery, $types, $value, $userid);

    
    if ($_SESSION['username'] === $username){
        $_SESSION[$column] = $value;
    }
    
    
    
    echo $updateSuccess;

}
