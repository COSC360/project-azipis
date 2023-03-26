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
    $rows[] = $row;
}

echo json_encode($rows);

?>