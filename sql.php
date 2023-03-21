<?php include_once 'connection.php';?>

<?php

//For sql selection queries
//RETURN: FALSE for failure, RESULT OBJECT for success
function php_select($query) {
    $conn = getConnection();
    $result = mysqli_query($conn, $query);
    return $result;
}

//For sql insertion queries
//RETURN: FALSE for failure, TRUE for success
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


//For sql queries that have a auto-increment id
//Should be called immediately after an insert statement
//RETURN: value generated for an AUTO_INCREMENT column by the last query or 0 for failure
function php_get_last_insert_id() {
    $conn = getConnection();
    $result = mysqli_insert_id($conn);
    return $result;
}


?>