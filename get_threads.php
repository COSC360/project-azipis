<?php
include_once 'functions.php';
session_start();

$returnjson = [];
$cid = get_sanitized_int_param($_GET, 'cid');
$all = get_sanitized_int_param($_GET, 'all');
$sort = get_sanitized_string_param($_GET, 'sort');

if ($cid != 0){

    // select all threads for community cid
    $query = "";
    switch ($sort) {
        case "new":
            $query = "SELECT * FROM thread
            JOIN (
              SELECT SUM(vote) as points, tid FROM thread_votes 
              GROUP BY tid
            ) AS m 
            ON thread.tid = m.tid
            WHERE communityid = ? ORDER BY created DESC";
            break;
        case "trending":
            $query = 
            "SELECT * FROM thread 
            JOIN (
              SELECT SUM(vote) as points, tid FROM thread_votes 
              GROUP BY tid
            ) AS m 
            ON thread.tid = m.tid
            WHERE communityid = ?
            ORDER BY points DESC
            ";
            break;
        case "controversial":
            $query = 
            "SELECT * FROM thread 
            JOIN (
              SELECT SUM(vote) as points, tid FROM thread_votes 
              GROUP BY tid
            ) AS m 
            ON thread.tid = m.tid
            WHERE communityid = ?
            ORDER BY points ASC
            ";
            break;
        default:
            $query = "SELECT * FROM thread WHERE communityid = ?";
            break;
        }
    $result = php_select_prepared($query, "i", $cid);

    if ($result) {
        $returnjson['success'] = true;
        $returnjson['threads'] = [];
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $returnjson['threads'][$i] = $row;
            $returnjson['threads'][$i]['username'] = get_username_from_id($row['userid']);
            $i = $i + 1;
        }
        die(json_encode($returnjson));
    } else {
        $returnjson['success'] = false;
        $returnjson['str'] = "Uhhh errorrrrrrrrrrrrrrrrrrr";
        $returnstr = json_encode($returnjson);
        die($returnstr);
    }


} else if($all == 1) {
    // select all threads
    $query = 
            "SELECT * FROM thread 
            JOIN (
              SELECT SUM(vote) as points, tid FROM thread_votes 
              GROUP BY tid
            ) AS m 
            ON thread.tid = m.tid
            ORDER BY points DESC
            ";
    $result = php_select($query);

    if ($result) {
        $returnjson['success'] = true;
        $returnjson['threads'] = [];
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $returnjson['threads'][$i] = $row;
            $returnjson['threads'][$i]['username'] = get_username_from_id($row['userid']);
            $returnjson['threads'][$i]['points'] = get_thread_points($row['tid']);
            $returnjson['threads'][$i]['cname'] = get_community_name_from_cid($row['communityid']);
            $i = $i + 1;
        }
        die(json_encode($returnjson));
    } else {
        $returnjson['success'] = false;
        $returnjson['str'] = "No";
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