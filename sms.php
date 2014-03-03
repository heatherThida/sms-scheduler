<?php
/*
 * Use autoloader instead
 */
include_once('./lib/twilio-php/Services/Twilio.php');
include_once('./includes/config.php');
include_once('./includes/common.php');
include_once('./Sms/Db.php');

$smsData = $_POST;

$db = new Database();
$savePost = $db->savePostData('log', $smsData);

if(!$savePost) {
    // Post Data could not be saved
    // Return meaningful error here
    echo "Sorry, we could not schedule your sms";
}

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