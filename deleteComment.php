<?php 

session_start();

include 'functions.php';
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true ){
    echo "0";
    die();
}

$commentid = get_sanitized_string_param($_POST, 'cid');

// get userid
$query = "SELECT userid FROM comment WHERE commentid = ?";
$types = "i";
$result = php_select_prepared($query, $types, $commentid);
$row = mysqli_fetch_assoc($result);
$userid = $row['userid'];

$comment_owner = get_username_from_id($userid);


if ($_SESSION['isAdmin'] === 1 || $_SESSION['username'] === $comment_owner) {



//delete thread query
$query = "DELETE FROM comment WHERE commentid = ?";
$types = "i";




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

} else {
    echo "0";
    die();
}


?>