<?php include 'connection.php';?>

<?php
$sql = "SELECT * FROM Community";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    echo "Community: " . $row["name"] . "<br>";
}
mysqli_close($conn);


?>