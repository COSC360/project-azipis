<?php

include_once "functions.php";

/*
$conn = getConnection();
$stmt = $conn->prepare('SELECT * FROM thread JOIN users on thread.userid = users.userid WHERE username = ? ORDER BY created DESC');
$username = $_GET['username'];
$stmt->bind_param("i", $username);
$stmt->execute();
$result = $stmt->get_result();
*/
$username = $_GET['username'];
$query = 'SELECT * FROM thread JOIN users on thread.userid = users.userid WHERE username = ? ORDER BY created DESC;';
$types = 's';
$result = php_select_prepared($query, $types, $username);

$rows = array();
while ($row = $result->fetch_assoc()) {

    $tid = $row['tid'];
    $points = get_thread_points($tid);
    $row['cname'] = get_community_name_from_cid($row['communityid']);

    // set points to $points
    $row['points'] = $points;

    // unset password from row
    unset($row['firstname']);
    unset($row['lastname']);
    unset($row['email']);
    unset($row['avatarimgpath']);
    unset($row['password']);
    unset($row['isAdmin']);
    unset($row['description']);
    $rows[] = $row;
}

echo json_encode($rows);

?>