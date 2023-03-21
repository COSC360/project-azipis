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
    echo "<script>location.replace('thread.php?tid=" . php_get_last_insert_id() . "')</script>";
} else {
    echo "Insertion failed";
    echo "<script>location.href='index.php'</script>";
}

?>