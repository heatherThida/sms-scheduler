<?php

include('../Sms/Db.php');

$x = new Database(DBHOST, DBUSER, DBPASS, DBNAME);

//print_r($x);

$y = $x->getSmsScheduledForNextFiveMinutes('log');
print_r($y);