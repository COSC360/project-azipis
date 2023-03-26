<?php

session_start();

include 'functions.php';

$column = get_sanitized_string_param($_POST, "column");
$value = get_sanitized_string_param($_POST,"value");
$userid = get_sanitized_int_param($_POST, "userid");


if ($column === 'password'){
    $value = password_hash($value, PASSWORD_DEFAULT);
}


$updateQuery = 'UPDATE users SET ' .$column. '= ? WHERE userid = ?;';
$types = 'si';
$updateSuccess = php_update($updateQuery, $types, $value, $userid);


$_SESSION[$column] = $value;


return $updateSuccess;

?>
