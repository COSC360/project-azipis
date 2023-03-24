<?php 
function get_sanitized_string_param($method,$constant){
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