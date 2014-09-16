<?php

include_once('../includes/common.php');
include_once('../includes/config.php');

// Set POST variables
$url = "http://kojo.com/sms.php";
$date = date('Y-m-d H:i:s', time());

// Fields to set and pass via curl call. 
$fields = array(
    'to'      => TEST_NUMBER,
    'from'    => TWILIO_NUMBER,
    "message" => "SMS from command line",
    "date"    => $date,
    "ip"      => "127.0.0.1",
);

//// url-ify the data for the POST
//foreach ($fields as $key => $value) {
//    $fields_string = $key.'='.$value.'&';
//}
//rtrim($fields_string, '&');
//print_r($fields_string);

$fields_string = http_build_query($fields);

// Open connection
$ch = curl_init();

// Set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

// Execute post
$result = curl_exec($ch);

// Close connection
curl_close($ch);

// Or alternatively use twilio object. 

require "../app/libs/twilio-php/Services/Twilio.php";

$client = new Services_Twilio(ACCOUNT_SID, AUTH_TOKEN); 

$message = $client->account->messages->create(array(
	"From" 	=> TWILIO_NUMBER,
	"TO" 	=> TEST_NUMBER, 
	"Body" 	=> "Test message!",
));

echo "Sent message {$message->sid}";