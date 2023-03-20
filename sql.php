<?php include_once 'connection.php';?>

<?php
function php_select($query) {
    $conn = getConnection();
    $result = mysqli_query($conn, $query);
    return $result;
}

function php_insert($query, $types, ...$binds) {
    $conn = getConnection();
    // Prepare the SQL statement
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        return false;
    }
    
    // Bind the parameters
    $stmt->bind_param($types, ...$binds);
    
    // Execute the statement
    $success = $stmt->execute();
    
    // Close the statement
    $stmt->close();
    
    // Return success or failure
    return $success;
}

?>