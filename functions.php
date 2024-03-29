<?php include_once 'connection.php';?>

<?php

/*

*********************************************************************************************

    SQL / DATABASE

    SPECIFIC FUNCTIONS HERE

*********************************************************************************************

*/

//For sql selection queries
//RETURN: FALSE for failure, RESULT OBJECT for success
function php_select($query) {
    $conn = getConnection();
    $result = mysqli_query($conn, $query);
    return $result;
}

//For prepared sql selection queries
//RETURN: FALSE for failure, RESULT OBJECT for success
function php_select_prepared($query, $types, ...$binds) {
    $conn = getConnection();
    // Prepare the SQL statement
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        return false;
    }
    
    // Bind the parameters
    $stmt->bind_param($types, ...$binds);
    
    // Execute the statement
    $stmt->execute();
    
    // Return success or failure
    return $stmt->get_result();
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

// to be implemented
function php_update($query, $types, ...$binds){

    return php_insert($query, $types, ...$binds);

}

// to be implemented
function php_delete_prepared($query, $types, ...$binds){
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

//RETURN: Username string from userid, "Anonymous" if id not found
function get_username_from_id($id) {
    if($id == NULL) {
        return "Anonymous";
    }

    $result = php_select("SELECT username FROM users WHERE userid =" . $id);
    $row = mysqli_fetch_assoc($result);
    $username = $row["username"];

    if($username == NULL) {
        return "Anonymous";
    }
    return $username;
}

// Return: uid from username, 0 if not found
function get_uid_from_username($username) {
    $result = php_select_prepared("SELECT userid FROM users WHERE username = ?", 's', $username);
    $row = mysqli_fetch_assoc($result);
    $uid = $row["userid"];
    return $uid;
}

function get_community_name_from_cid($cid) {
    $result = php_select_prepared("SELECT name FROM community WHERE communityid = ?", 'i', $cid);
    $row = mysqli_fetch_assoc($result);
    $name = $row["name"];
    return $name;
}

function get_entry_exists($table,$colname,$val,$valtype){
    $result = php_select_prepared("SELECT * FROM " . $table . " WHERE " . $colname . "= ?", $valtype, $val);
    if(mysqli_num_rows($result) > 0){
        return true;
    }
    return false;

}

// returns the points a thread has
function get_thread_points($tid){
    $query = 'SELECT SUM(vote) AS points from thread_votes WHERE tid = ?';
    $result = php_select_prepared($query, 'i', $tid);
    $row = mysqli_fetch_assoc($result);
    return $row["points"];
}

// returns the points a comment has
function get_comment_points($cid){
    $query = 'SELECT SUM(vote) AS points from comment_votes WHERE commentid = ?';
    $result = php_select_prepared($query, 'i', $cid);
    $row = mysqli_fetch_assoc($result);
    return $row["points"];
}

// returns the points a user has from threads
function get_user_thread_points($uid){
    $query = 'SELECT SUM(vote) as points FROM thread_votes JOIN thread ON thread_votes.tid = thread.tid WHERE thread.userid = ?';
    $result = php_select_prepared($query, 'i', $uid);
    $row = mysqli_fetch_assoc($result);
    return $row["points"];
}

// returns the points a user has from comments
function get_user_comment_points($uid){
    $query = 'SELECT SUM(vote) as points FROM comment_votes JOIN comment ON comment_votes.commentid = comment.commentid WHERE comment.userid = ?';
    $result = php_select_prepared($query, 'i', $uid);
    $row = mysqli_fetch_assoc($result);
    return $row["points"];
}

// returns total user points
function get_user_points($username){
    $uid = get_uid_from_username($username);
    $tp = get_user_thread_points($uid);
    $cp = get_user_comment_points($uid);
    return $tp + $cp;
}

// return tid and vote that user has voted on
function get_user_voted_tid($username){
    $uid = get_uid_from_username($username);
    $query = 'SELECT tid, vote FROM thread_votes WHERE userid = ?';
    $result = php_select_prepared($query, 'i', $uid);
    // return all rows from result
    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return json_encode($row);
}

if (isset($_POST['action']) && $_POST['action'] == "get_user_voted_tid") {
    echo get_user_voted_tid($_POST['username']);
    return;
}

// return cid that user has voted on
function get_user_voted_cid($username){
    $uid = get_uid_from_username($username);
    $query = 'SELECT commentid, vote FROM comment_votes WHERE userid = ?';
    $result = php_select_prepared($query, 'i', $uid);
    // return all rows from result
    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return json_encode($row);
}

if (isset($_POST['action']) && $_POST['action'] == "get_user_voted_cid") {
    echo get_user_voted_cid($_POST['username']);
    return;
}

/*

*********************************************************************************************

    HTML

    SPECIFIC FUNCTIONS HERE

*********************************************************************************************

*/

// Not sure if we want to keep these 2 functions here or move them
// Print out logged in header
function php_get_logged_in_header(){

    $username = $_SESSION['username'];
    $points = get_user_points($username);

    echo '<div class="btn-group">';
    echo '<a href="user.php?username='.$username. '" class="header-links">'.$username . '(' . $points. ')</a> | ' ;
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


/*

*********************************************************************************************

    Sanitization and Security

    SPECIFIC FUNCTIONS HERE

*********************************************************************************************

*/


function get_sanitized_string_param($method,$constant){
    $in = "";
    if(isset($method[$constant]) && !empty($method[$constant])){
        $in = $method[$constant];
        $in = htmlspecialchars($in, ENT_QUOTES, 'UTF-8');
        $in = str_replace(array("\n", "\r"), '', $in);
        if(gettype($in) != "string"){
           $in = "";
        }
    } else {
        $in = "";
    }

    return $in;
}

function get_non_html_sanitized_string_param($method,$constant){
    $in = "";
    if(isset($method[$constant]) && !empty($method[$constant])){
        $in = $method[$constant];
        if(gettype($in) != "string"){
           $in = "";
        }
    } else {
        $in = "";
    }

    return $in;
}

function get_sanitized_int_param($method,$constant){
    $in = 0;
    if(isset($method[$constant]) && !empty($method[$constant])){
        $in = intval($method[$constant]);
        if(gettype($in) != "integer"){
           $in = 0;
        }
    } else {
        $in = 0;
    }

    return $in;
}

function is_valid_int_param($int,$min,$max){
    if( $int < $min ||  $int > $max ){
        return false;
    } else {
        return true;
    }
}


?>