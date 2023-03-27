<?php 

session_start();

include 'functions.php';
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['isAdmin'] != 1){
    echo "0";
    die();
}

//delete thread query
$query = "DELETE FROM comment WHERE commentid = ?";
$types = "i";


$commentid = get_sanitized_string_param($_POST, 'cid');

if(!get_entry_exists("comment", "commentid", $commentid, "i")){
    echo $commentid;
    die();
}


$result = php_delete_prepared($query, $types, $commentid);

if ($result) {
    echo "1";
} else {
    echo "0";
}
die();
?>