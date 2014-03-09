<?php

require_once('includes/config.php');
include_once('Sms/Db.php');

$db = new Database();

$createDatabase = $db->createDatabase();

