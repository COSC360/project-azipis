<?php
include_once 'functions.php';
session_start();

$returnjson = [];
$cid = get_sanitized_int_param($_GET, 'cid');
$all = get_sanitized_int_param($_GET, 'all');

if ($cid != 0){

    // select all threads for community cid
    $query = "SELECT * FROM thread WHERE communityid = ?";
    $result = php_select_prepared($query, "i", $cid);

    if ($result) {
        $returnjson['success'] = true;
        $returnjson['threads'] = [];
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $returnjson['threads'][$i] = $row;
            $returnjson['threads'][$i]['username'] = get_username_from_id($row['userid']);
            $returnjson['threads'][$i]['points'] = get_thread_points($row['tid']);
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
    $query = "SELECT * FROM thread";
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
        $returnjson['str'] = "Error";
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