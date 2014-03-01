<?php

include('../Sms/Db.php');

$x = new Database(DBHOST, DBUSER, DBPASS, DBNAME);

//print_r($x);

$y = $x->savePostData('log', array('to' => 'me'));
print_r($y);