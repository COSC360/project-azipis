<?php 

session_start();

include 'functions.php';
if($_SESSION['isAdmin'] != 1){
    header("Location: index.php");
    die();
}

//delete thread query
$query = "DELETE FROM Thread WHERE tid = ?";
$types = "i";


$threadid = get_sanitized_string_param($_POST, 'tid');

if(!get_entry_exists("Thread", "tid", $threadid, "i")){
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