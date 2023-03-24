<?php 
function get_sanitized_param($method,$constant){
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
?>