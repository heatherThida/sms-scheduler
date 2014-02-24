<?php

include_once('./lib/twilio-php/Services/Twilio.php');
include_once('./includes/config.php');
include_once('./includes/common.php');

$to = $_POST["to"];
$from = $_POST["from"];
$ip = $_POST["ip"];
$message = $_POST["message"];
$date = $_POST["date"];
$hour = $_POST["hour"];
$minute = $_POST["minute"];

// Set time
$parsedDate = date_parse($date);
$year = $parsedDate['year'];
$month = $parsedDate['month'];
$day = $parsedDate['day'];

$scheduled_time = new DateTime($date . "$hour:$minute");
// Save time as string instead of object
$scheduled_time = $scheduled_time->format('m/d/Y H:i:s');

debug($scheduled_time);

// Array to store data
$sms_data = array(
    'status' => 'pending' ,
    'from_number' => $from,
    'to_number' => $to,
    'message' => $message,
    'sms_scheduled_day' => $day,
    'sms_scheduled_month' => $month,
    'sms_scheduled_year' => $year,
    'sms_scheduled_hour' => $hour,
    'sms_scheduled_minute' => $minute,
    'ip' => $ip,
    'scheduled_at' => time(),
);

$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

// Check connection
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") ";
    exit;
}

$sql = "INSERT INTO log
        (status, from_number, to_number, message, sms_scheduled_time,
        sms_scheduled_day, sms_scheduled_month, sms_scheduled_year,
        sms_scheduled_hour, sms_scheduled_minute, ip)
        VALUES
        ('pending', '$from', '$to', '$message', '$scheduled_time', '$day', '$month', '$year', '$hour', '$minute', '$ip');";

$insertData = $db->query($sql);

if ($insertData) {
    echo "Data has been successfully inserted.\n";
} else {
    echo "Oops, could not insert data.<br />\n";
    echo $db->error;
}

// Close MySQL connection
$db->close();

?>



<!DOCTYPE HTML>
<html>
	<head>
		<title>SMS Scheduler</title>
		<?php include 'head.php'; ?>
	</head>
	<body>
		<p>Thanks for the submission.. </p>

		<?php
		echo "To $to <br />";
		echo "From $from <br />";
		echo "Message: $message <br />";
		echo "Date: $date <br />";
		?>

<!--        --><?php
//
//        $client = new Services_Twilio(SID, TOKEN);
//
//         $message = $client->account->messages->sendMessage(
//                            TWILIO_NUMBER,
//                            $to,
//                            $message
//                     );
//
//        ?>
		
		<?php include 'footer.php'; ?>
	</body>
</html>