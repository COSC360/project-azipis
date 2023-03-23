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








// Not sure if we want to keep these 2 functions here or move them
// Print out logged in header
function php_get_logged_in_header(){
    echo '<div class="btn-group">';
    echo '<a href="user.php?username='.$_SESSION['username']. '" class="header-links">'.$_SESSION['username'] . '(points)</a> | ' ;
    echo '<a href="logout.php" class="header-links">Logout</a>';
    echo '</div>';
}

// Print out logged in header
function php_get_header(){
    echo '<div class="btn-group">';
    echo '<a href="#" class="button" onclick="openLogin()">Login</a>';
    echo '<a href="createAccount.php" class="button">Create Account</a>';
    echo '</div>';
}


?>