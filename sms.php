<?php
/*
 * Use autoloader instead
 */
include_once('./lib/twilio-php/Services/Twilio.php');
include_once('./includes/config.php');
include_once('./includes/common.php');
include_once('./Sms/Db.php');

//$errors         = array();      // Array to hold validation errors
//$data           = array();      // Array to pass back data
//

//if (empty($_POST["to"])){
//    $errors['to'] = 'Please enter a number to send to';
//}
//
//if (empty($_POST["from"])) {
//    $errors['from'] = 'Please enter your cell phone number';
//}
//
//if (empty($_POST["message"])) {
//    $errors['message'] = 'Sorry, an empty sms cannot be sent.';
//}
//
//if (empty($_POST["date"])) {
//    $errors['date'] = 'Date is required.';
//}
//
//if (empty($_POST["hour"])) {
//    $errors['hour'] = 'Hour is required.';
//}
//
//if (empty($_POST["minute"])) {
//    $errors['minute'] = 'Minute is required.';
//}
//
//if ( !empty($errors)) {
//    // Return errors
//    $data['success'] = false;
//    $data['errors'] = $errors;
//} else {
//    $data['success'] = true;
//    $data['message'] = 'Success';
//}
//
//// return data
//echo json_encode($data);
//
//$to = $_POST["to"];
//$from = $_POST["from"];
//$ip = $_POST["ip"];
//$message = $_POST["message"];
//$date = $_POST["date"];
//$hour = $_POST["hour"];
//$minute = $_POST["minute"];
//
//// Set time
//$parsedDate = date_parse($date);
//$year = $parsedDate['year'];
//$month = $parsedDate['month'];
//$day = $parsedDate['day'];
//
//$scheduled_time = new DateTime($date . "$hour:$minute");
//// Save time as string instead of object
//$scheduled_time = $scheduled_time->format('m/d/Y H:i:s');
//
//debug($scheduled_time);
//
//// Array to store data
//$sms_data = array(
//    'status' => 'pending' ,
//    'from_number' => $from,
//    'to_number' => $to,
//    'message' => $message,
//    'sms_scheduled_day' => $day,
//    'sms_scheduled_month' => $month,
//    'sms_scheduled_year' => $year,
//    'sms_scheduled_hour' => $hour,
//    'sms_scheduled_minute' => $minute,
//    'ip' => $ip,
//    'scheduled_at' => time(),
//);
//
//$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
//
//// Check connection
//if ($db->connect_errno) {
//    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") ";
//    exit;
//}
//
//$sql = "INSERT INTO log
//        (status, from_number, to_number, message, sms_scheduled_time,
//        sms_scheduled_day, sms_scheduled_month, sms_scheduled_year,
//        sms_scheduled_hour, sms_scheduled_minute, ip)
//        VALUES
//        ('pending', '$from', '$to', '$message', '$scheduled_time', '$day', '$month', '$year', '$hour', '$minute', '$ip');";
//
//$insertData = $db->query($sql);
//
//if ($insertData) {
//    echo "Data has been successfully inserted.\n";
//} else {
//    echo "Oops, could not insert data.<br />\n";
//    echo $db->error;
//}
//
//// Close MySQL connection
//$db->close();
//
//?>


<?php

$smsData = $_POST;

$db = new Database();
$data = $db->savePostData('log', $smsData);

debug($smsData);

?>


<!DOCTYPE HTML>
<html>
	<head>
		<title>SMS Scheduler</title>
		<?php include 'head.php'; ?>
	</head>
	<body>
		<p>Thanks for the submission.. </p>
		
		<?php include 'footer.php'; ?>
	</body>
</html>