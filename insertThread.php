<?php 

include 'sql.php';

$query = "INSERT INTO Thread (title, communityid, created, points, content) VALUES (?, ?, NOW(), 0, ?)";
$types = "sis";

$title = $_POST['title'];
$communityid = $_POST['communityid'];
$content = $_POST['content'];

$result = php_insert($query, $types, $title, $communityid, $content);

if ($result) {
    echo "Insertion succeeded";
} else {
    echo "Insertion failed";
}

?>