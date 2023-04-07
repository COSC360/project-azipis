<?php

include_once "functions.php";


$username = $_GET['username'];
$type = $_GET['type'];


if ($type == 'up') {
    $query = ('SELECT comment.commentid, comment.comment, comment.created, comment.userid, users.username 
                FROM (SELECT commentid FROM `comment_votes` WHERE userid = ? and vote = 1) as c 
                JOIN comment ON c.commentid = comment.commentid JOIN users 
                on comment.userid = users.userid
                ORDER BY comment.created DESC;');
    $types = 'i';
    $userid = get_uid_from_username($username);
    $result = php_select_prepared($query, $types, $userid);
    $rows = array();
    while ($row = $result->fetch_assoc()) {

            
        $cid = $row['commentid'];
        $points = get_comment_points($cid);
        $row['points'] = $points;

        unset($row['tid']);
        

        $rows[] = $row;

    }

    $query2 = ('SELECT thread.tid, thread.title, thread.communityid, thread.threadtype, thread.created, thread.content, users.userid, users.username 
                FROM (SELECT tid FROM `thread_votes` WHERE userid = ? and vote = 1) as t 
                JOIN thread ON t.tid = thread.tid JOIN users on thread.userid = users.userid
                ORDER BY thread.created DESC;');
    $types = 'i';
    $result = php_select_prepared($query2, $types, $userid);
    $rows2 = array();
    while ($row = $result->fetch_assoc()) {
        
        $tid = $row['tid'];
        $points = get_thread_points($tid);
        $row['points'] = $points;

        // add $row to the previous $rows
        $rows2[] = $row;
    }

    $combined_rows = array_merge($rows, $rows2);
    echo json_encode($combined_rows);

    
    
} else if ($type == 'down'){

    $query = ('SELECT comment.commentid, comment.comment, comment.created, comment.userid, users.username 
                FROM (SELECT commentid FROM `comment_votes` WHERE userid = ? and vote = -1) as c 
                JOIN comment ON c.commentid = comment.commentid JOIN users 
                on comment.userid = users.userid
                ORDER BY comment.created DESC;');
    $types = 'i';
    $userid = get_uid_from_username($username);
    $result = php_select_prepared($query, $types, $userid);
    $rows = array();
    while ($row = $result->fetch_assoc()) {

            
        $cid = $row['commentid'];
        $points = get_comment_points($cid);
        $row['points'] = $points;

        unset($row['tid']);
        

        $rows[] = $row;

    }

    $query2 = ('SELECT thread.tid, thread.title, thread.communityid, thread.threadtype, thread.created, thread.content, users.userid, users.username 
                FROM (SELECT tid FROM `thread_votes` WHERE userid = ? and vote = -1) as t 
                JOIN thread ON t.tid = thread.tid JOIN users on thread.userid = users.userid
                ORDER BY thread.created DESC;');
    $types = 'i';
    $result = php_select_prepared($query2, $types, $userid);
    $rows2 = array();
    while ($row = $result->fetch_assoc()) {
        
        $tid = $row['tid'];
        $points = get_thread_points($tid);
        $row['points'] = $points;

        // add $row to the previous $rows
        $rows2[] = $row;
    }

    $combined_rows = array_merge($rows, $rows2);
    echo json_encode($combined_rows);



} else {

    echo 'error';
    die();

}



?>

