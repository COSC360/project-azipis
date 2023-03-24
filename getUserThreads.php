<?php

include_once "sql.php";


$conn = getConnection();
$stmt = $conn->prepare('SELECT * FROM thread JOIN users on thread.userid = users.userid WHERE users.username = ? ORDER BY created DESC');
$username = $_GET['username'];
$stmt->bind_param("i", $username);
$stmt->execute();
$result = $stmt->get_result();

$rows = array();
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode($rows);

?>