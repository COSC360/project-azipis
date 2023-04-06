<?php
include_once 'functions.php';
session_start();

// if not logged in, echo not logged in and die
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    echo "Vote failed, not logged in.";
    die();
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
        echo "1";
    } else {
        echo "0";
    }
    die();


} else if ($type == "comment"){

    // insert query or update if already voted on comment
    $query = "INSERT INTO comment_votes (userid, commentid, vote) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE vote = VALUES(vote)";
    $result = php_insert($query, "iii", $userid, $id, $vote);

    if ($result) {
        echo "1";
    } else {
        echo "0";
    }
    die();

} else {
    echo "Vote failed, unknown type.";
    die();
}

?>