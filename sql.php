<?php include_once 'connection.php';?>

<?php
function php_select($query) {
    $conn = getConnection();
    $result = mysqli_query($conn, $query);
    return $result;
}

?>