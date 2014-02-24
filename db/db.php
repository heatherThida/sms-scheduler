<?php

include_once('../includes/config.php');

$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

// Check connection
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") ";
    exit;
}

$drop_tables = "DROP TABLE log";

// Should use "CREATE TABLE IF NOT EXISTS log
$log = "CREATE TABLE IF NOT EXISTS log
        (
         id INT NOT NULL AUTO_INCREMENT,
         status varchar(25),
         from_number VARCHAR(255),
         to_number VARCHAR(255),
         message TEXT,
         sms_scheduled_day INT(2),
         sms_scheduled_month INT(2),
         sms_scheduled_year INT(4),
         sms_scheduled_hour INT(2),
         sms_scheduled_minute INT(2),
         sms_scheduled_second INT(2),
         ip BIGINT(20),
         twilio_response TEXT,
         created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
         sms_scheduled_time DATETIME,
         scheduled_at TIMESTAMP,
         executed_at TIMESTAMP,
         finished_at TIMESTAMP,
         PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ";

$drop_tbls = $db->query($drop_tables);

if ($drop_tbls) {
    echo "Table has been successfully dropped.\n";
} else {
    echo "Oops, could not drop table.\n" . $db->connect_error;
}

$create_tbl = $db->query($log);

if ($create_tbl) {
    echo "Table has been successfully created.\n";
} else {
    echo "Oops, could not create table.\n";
    echo $db->connect_error;
}

$db->close();