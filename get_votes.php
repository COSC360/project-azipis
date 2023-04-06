<?php
include_once 'functions.php';
session_start();

$returnjson = [];
$id = get_sanitized_int_param($_GET, 'id');
$type = get_sanitized_string_param($_GET, 'type');

if ($type == "thread"){

    // sum up all votes for threadid
    $query = "SELECT SUM(vote) as points FROM thread_votes WHERE tid = ?";
    $result = php_select_prepared($query, "i", $id);

    if ($result) {
        $returnjson['success'] = true;
        $returnjson['points'] = mysqli_fetch_assoc($result)["points"];
        $returnstr = json_encode($returnjson);
        die($returnstr);
    } else {
        $returnjson['success'] = false;
        $returnjson['str'] = "Error with thread";
        $returnstr = json_encode($returnjson);
        die($returnstr);
    }


} else if ($type == "comment"){

    // sum up all votes for commentid
    $query = "SELECT SUM(vote) as points FROM comment_votes WHERE commentid = ?";
    $result = php_select_prepared($query, "i", $id);

    if ($result) {
        $returnjson['success'] = true;
        $returnjson['points'] = mysqli_fetch_assoc($result)["points"];
        $returnstr = json_encode($returnjson);
        die($returnstr);
    } else {
        $returnjson['success'] = false;
        $returnstr = json_encode($returnjson);
        die($returnstr);
    }

} else {
    $returnjson['success'] = false;
    $returnjson['str'] = "Something is broken";
    $returnstr = json_encode($returnjson);
    exit($returnstr);
}

?>