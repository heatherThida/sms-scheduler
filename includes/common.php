<?php

/** Error reporting on **/ 
error_reporting(E_ALL);

/** Display errors **/
ini_set('display_errors', 1);

function debug($object){
    echo "<pre>";
    print_r($object);
    echo "</pre>";
}

