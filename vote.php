<?php
include_once 'functions.php';
session_start();

$returnjson = [];
// if not logged in, echo not logged in and die
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    $returnjson['success'] = false;
    $returnstr = json_encode($returnjson);
    die($returnstr);
}

$id = get_sanitized_int_param($_POST, 'id');
$vote = get_sanitized_int_param($_POST, 'vote');
$userid = $_SESSION['userid'];
$type = get_sanitized_string_param($_POST, 'type');

if ($type == "thread"){

    // insert query or update if already voted on thread
    $query = "INSERT INTO thread_votes (userid, tid, vote) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE vote = VALUES(vote)";
    $result = php_insert($query, "iii", $userid, $id, $vote);

    if ($result) {
        $returnjson['success'] = true;
        $returnstr = json_encode($returnjson);
        die($returnstr);
    } else {
        $returnjson['success'] = false;
        $returnstr = json_encode($returnjson);
        die($returnstr);
    }


} else if ($type == "comment"){

    // insert query or update if already voted on comment
    $query = "INSERT INTO comment_votes (userid, commentid, vote) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE vote = VALUES(vote)";
    $result = php_insert($query, "iii", $userid, $id, $vote);

    if ($result) {
        $returnjson['success'] = true;
        $returnstr = json_encode($returnjson);
        die($returnstr);
    } else {
        $returnjson['success'] = false;
        $returnstr = json_encode($returnjson);
        die($returnstr);
    }

} else {
    $returnjson['success'] = false;
    $returnstr = json_encode($returnjson);
    exit($returnstr);
}

?>