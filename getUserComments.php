<?php

include_once "sql.php";
include_once "security.php";


$conn = getConnection();
$stmt = $conn->prepare('SELECT * FROM comment JOIN users on comment.userid = users.userid WHERE users.username = ? ORDER BY created DESC');
$username = get_sanitized_string_param($_GET,'username');
$stmt->bind_param("i", $username);
$stmt->execute();
$result = $stmt->get_result();

$rows = array();
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

json_encode($rows);

?>