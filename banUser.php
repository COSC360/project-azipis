<?php 

session_start();

include 'functions.php';
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['isAdmin'] != 1){
    echo "0";
    die();
}

//insert into ban table query
$query = "INSERT INTO ban (userid, adminid, bandate, expiredate, banreason) VALUES (?, ?, ?, ?, ?)";

$types = "iisss";


$userid = get_sanitized_int_param($_POST, 'userid');
$adminid = get_sanitized_int_param($_POST, 'adminid');
$bandate = get_sanitized_string_param($_POST, 'bandate');
$expiredate = get_sanitized_string_param($_POST, 'expiredate');
$banreason = get_sanitized_string_param($_POST, 'banreason');

if(!get_entry_exists("users", "userid", $userid, "i")){
    echo "UserID does not exist:" . $userid;
    die();
}


$result = php_insert($query, $types, $userid, $adminid, $bandate, $expiredate, $banreason);

if ($result) {
    echo "1";
} else {
    echo "0";
}
die();
?>