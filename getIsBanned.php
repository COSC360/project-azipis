<?php

require_once 'functions.php';

$query = "SELECT * FROM ban WHERE userid = ? AND expiredate > CURRENT_DATE;";

$userid = get_sanitized_int_param($_GET,"userid");
$types = "i";

$isbanned = php_select_prepared($query, $types, $userid);
if(mysqli_num_rows($isbanned ) > 0){
    echo "1";
} else {
    echo "0";
}
?>
