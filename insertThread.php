<?php 

session_start();

include 'functions.php';
if(!isset($_SESSION['userid'])){
    header("Location: index.php");
    die();
}
$query = "INSERT INTO thread (title, communityid, created, points, content, userid, threadtype) VALUES (?, ?, NOW(), 0, ?, ?, ?)";
$types = "sisii";

$title = get_sanitized_string_param($_POST, 'title');
$communityid = get_sanitized_int_param($_POST, 'communityid');
$content = get_sanitized_string_param($_POST, 'content');
$userid = $_SESSION['userid'];
$threadtype = get_sanitized_int_param($_POST,'threadtype');
if($threadtype < 1 || $threadtype > 3){
    header("Location: index.php");
    die();
}

if(strlen($title) < 1 || strlen($title) > 100 || strlen($content) < 1 || strlen($content) > 1000){
    header("Location: index.php");
    die();
}

if(!get_entry_exists("community", "communityid", $communityid, "i")){
    header("Location: index.php");
    die();
}


$result = php_insert($query, $types, $title, $communityid, $content, $userid, $threadtype);

if ($result) {
    echo "Insertion succeeded";
    echo "<script>location.replace('thread.php?tid=" . php_get_last_insert_id() . "')</script>";
} else {
    echo "Insertion failed";
    echo "<script>location.href='index.php'</script>";
}

?>