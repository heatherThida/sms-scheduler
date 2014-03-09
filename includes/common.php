<?php

/** Error reporting on **/ 
error_reporting(E_ALL);

/** Display errors **/
ini_set('display_errors', 1);
ini_set('error_log', 'log/errors.log.txt');



function debug($object){
    echo "<pre>";
    print_r($object);
    echo "</pre>";
}

function selectOptions($begin, $end){

    for($i = $begin; $i < $end; $i++) {
        echo '<option value="' . $i . '" >' . $i . '</option>';
    }
//    <option value="00" selected="selected">00</option>
//                            <option value="01" >01</option>
}