<?php

include 'functions.php';
$query = "SELECT * FROM users WHERE username = ?";

$username = get_sanitized_string_param($_GET,"username");
$types = "s";

$result = php_select_prepared($query, $types, $username);
if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    unset($row['password']);
    echo json_encode($row);
}
?>
