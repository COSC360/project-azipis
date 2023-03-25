<?php 
include 'functions.php';
session_start();

$query = "INSERT INTO Comment (comment, tid, created, points, userid) VALUES (?, ?, NOW(), 0, ?)";
$types = "sii";

$comment = get_sanitized_string_param($_POST,'comment');
$threadid = get_sanitized_int_param($_POST,'tid');
$result = false;

if(strlen($comment) < 1 || strlen($comment) > 500){
    header("Location: index.php");
    die();
}
if(!get_entry_exists("thread", "tid", $threadid, "i")){
    header("Location: index.php");
    die();
}

if(isset($_SESSION['uid'])){
    $result = php_insert($query, $types, $comment, $threadid, $_SESSION['uid']);
} else {
    $result = false;
}

if ($result) {
    header("Location: thread.php?tid=" . $threadid);
    die();
} else {
    header("Location: thread.php?tid=" . $threadid);
    die();
}

?>