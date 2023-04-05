<?php 

session_start();

include 'functions.php';
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true ){
    echo "0";
    die();
}

$threadid = get_sanitized_string_param($_POST, 'tid');

// get userid
$query = "SELECT userid FROM thread WHERE tid = ?";
$types = "i";
$result = php_select_prepared($query, $types, $threadid);
$row = mysqli_fetch_assoc($result);
$userid = $row['userid'];

$thread_owner = get_username_from_id($userid);


if ($_SESSION['isAdmin'] === 1 || $_SESSION['username'] === $thread_owner) {

//delete thread query
$query = "DELETE FROM thread WHERE tid = ?";
$types = "i";


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

} else {
    echo "0";
    die();
}

?>