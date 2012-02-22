<?php

/******************************************************
*  @desc: Transposes an associative array 			  *
*  @param: An array of arrays 						  * 
*  @return: An array of arrays where rows became cols *
*													  *
/*****************************************************/


function transpose($array) {
    if (!is_array($array)) return false;
    
    $out = array();
    
    foreach ($array as $key => $subarr) {

        foreach ($subarr as $subkey => $subvalue) {

                $out[$subkey][$key] = $subvalue;
        }
    }
    
    return $out;
}
?>