<?php

include_once('./includes/config.php');
/*
 1. Run through database and look for scheduled time
 2. If scheduled time is less than a minute away, note the ID,
 3. Create an array of all "$to" numbers and "$messages" for the next send
 4. Mass send out the messages via twilio
*/

$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

// Check connection
if (mysqli_connect_errno()) {
    printf("Connection to MySQL failed: %s\n", mysqli_connect_error());
    exit;
}

// Loop through database and queue all rows with pending status and scheduled
// time - now < 1 minute.  

// Close Connection
$mysqli->close();

?>