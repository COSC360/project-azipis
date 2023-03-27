<?php

include 'functions.php';
$query = "SELECT * FROM ban WHERE userid = ? AND expiredate > CURRENT_DATE;";

$userid = get_sanitized_int_param($_GET,"userid");
$types = "i";

$result = php_select_prepared($query, $types, $userid);
if(mysqli_num_rows($result) > 0){
    echo "1";
} else {
    echo "0";
}
?>
