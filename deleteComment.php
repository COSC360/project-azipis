<?php 

session_start();

include 'functions.php';
if($_SESSION['isAdmin'] != 1){
    header("Location: index.php");
    die();
}

//delete thread query
$query = "DELETE FROM Comment WHERE commentid = ?";
$types = "i";


$commentid = get_sanitized_string_param($_POST, 'cid');

if(!get_entry_exists("Comment", "commentid", $commentid, "i")){
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