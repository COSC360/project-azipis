<?php 
include 'sql.php';
session_start();

$query = "INSERT INTO Comment (comment, tid, created, points, userid) VALUES (?, ?, NOW(), 0, ?)";
$types = "sii";

$comment = $_POST['comment'];
$threadid = $_POST['tid'];
$result = false;

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