<?php 

session_start();

include 'functions.php';
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['isAdmin'] != 1){
    echo "0";
    die();
}

//delete thread query
$query = "DELETE FROM thread WHERE tid = ?";
$types = "i";


$threadid = get_sanitized_string_param($_POST, 'tid');

if(!get_entry_exists("thread", "tid", $threadid, "i")){
    echo "0";
    die();
}


$result = php_delete_prepared($query, $types, $threadid);

if ($result) {
    echo "1";
} else {
    echo "0";
}
die();
?>