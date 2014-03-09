<?php

include_once('./includes/common.php');
include_once('./includes/config.php');
include_once('./Sms/Db.php');
//include_once('./Sms/Scheduler.php');
include_once('./Sms/Sms.php');
include_once('./lib/twilio-php/Services/Twilio.php');


/*
 1. Run through database and look for scheduled time
 2. If scheduled time is less than a minute away, note the ID,
 3. Create an array of all "$to" numbers and "$messages" for the next send
 4. Mass send out the messages via twilio
*/

$db = new Database();
$sms = new Sms();

$findSmsToSend = $db->getSmsScheduledForNextFiveMinutes();

print_r($findSmsToSend);

$sentSms = $sms->send($findSmsToSend);

print_r($sentSms);

//$smsStatus = $db->getSmsStatus();

//debug($sentSms);
//debug($sentSms);

?>