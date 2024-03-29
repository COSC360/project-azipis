<?php
include_once 'functions.php';
session_start();

$returnjson = [];
$tid = get_sanitized_int_param($_GET, 'tid');

if ($tid != 0){

    // select all comments for threadid tid
    $query = "SELECT * FROM comment WHERE tid = ?";
    $result = php_select_prepared($query, "i", $tid);

    if ($result) {
        $returnjson['success'] = true;
        $returnjson['comments'] = [];
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $returnjson['comments'][$i] = $row;
            $returnjson['comments'][$i]['username'] = get_username_from_id($row['userid']);
            $returnjson['comments'][$i]['points'] = get_comment_points($row['commentid']);
            $i = $i + 1;
        }
        die(json_encode($returnjson));
    } else {
        $returnjson['success'] = false;
        $returnjson['str'] = "Uhhh errorrrrrrrrrrrrrrrrrrr";
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