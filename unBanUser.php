<?php 

session_start();

include 'functions.php';
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['isAdmin'] != 1){
    echo "0";
    die();
}

//insert into ban table query
$query = "DELETE FROM ban WHERE userid = ?";
$types = "i";


$userid = get_sanitized_int_param($_POST, 'userid');

if(!get_entry_exists("Users", "userid", $userid, "i")){
    echo "UserID does not exist:" . $userid;
    die();
}


$result = php_insert($query, $types, $userid);

if ($result) {
    echo "1";
} else {
    echo "0";
}
die();
?>