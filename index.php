<?php
    include_once('./includes/common.php');
?>

<?php
    $ip = getenv('HTTP_CLIENT_IP')?:
          getenv('HTTP_X_FORWARDED_FOR')?:
          getenv('HTTP_X_FORWARDED')?:
          getenv('HTTP_FORWARDED_FOR')?:
          getenv('HTTP_FORWARDED')?:
          getenv('REMOTE_ADDR');

    $ip = ip2long($ip);
?>


<!DOCTYPE HTML>
<html>
	<head>
		<title>SMS Scheduler</title>
		<?php include 'head.php'; ?>
	</head>
	<body>
		<div class="container">
            <div class="col-sm-6 col-sm-offset-3">

                <form name="sms-form" id="sms-form" class="form-schedule-sms" role="form" action="sms.php" method="post">
                    <fieldset>
                        <!-- SMS TO -->
                        <div id=""to-group" class="form-group">
                            <label for="to">To</label>
                            <input type="text" class="form-control" name="to" id="to" placeholder="(212) 000-0000">
                        </div>
                        <!-- SMS From -->
                        <div id="from-group" class="form-group">
                            <label for="from">From</label>
                            <input type="text" class="form-control" name="from" id="from" placeholder="(212) 000-1111">
                        </div>
                        <!-- SMS Message -->
                        <div id="message-group" class="form-group">
                            <label for="message">Message</label>
                            <textarea maxlength="140" name="message" id="message" required></textarea>
                        </div>

                        <!-- Date to schedule SMS -->
                        <div id="message-group" class="form-group">
                            <label for="message">Date</label>
                            <input type="text" id="date" name="date">
                        </div>


                        Hour: <select id="hour" name="hour">
                                <?php selectOptions(0, 24); ?>
                        </select>
                        Minute: <select id="minute" name="minute">
                            <?php selectOptions(0, 60); ?>
                        </select>
                        <input type="hidden" name="ip" value="<?php echo $ip ?>" />
                        <button class="btn btn-lg btn-success btn-block" type="submit">Submit</button>
                    </fieldset>
            </form>
            </div> <!-- End col-sm-6 -->
		</div> <!-- /container -->
	
		<?php include 'footer.php'; ?>
	</body>
</html>
