<?php

include_once "functions.php";

/*
$conn = getConnection();
$stmt = $conn->prepare('SELECT * FROM comment JOIN users on comment.userid = users.userid WHERE users.username = ? ORDER BY created DESC');
$username = get_sanitized_string_param($_GET,'username');
$stmt->bind_param("i", $username);
$stmt->execute();
$result = $stmt->get_result();
*/

$username = $_GET['username'];
$query = 'SELECT * FROM comment JOIN users on comment.userid = users.userid WHERE username = ? ORDER BY created DESC;';
$types = 's';
$result = php_select_prepared($query, $types, $username);

$rows = array();
while ($row = $result->fetch_assoc()) {

    $cid = $row['commentid'];
    $points = get_comment_points($cid);

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