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
		<script>
			$(function() {
				$("#date").datepicker({
                    //options go here
                    showOtherMonths: true,
                    selectOtherMonths: true,
                    minDate: 0,
                    maxDate: "+3M"
                });
				$("#anim").change(function() {
					$("#date").datepicker("option", "showAnim", $(this).val() )
					})
				})
		</script
	</head>
	<body>
		<div class="container">
			<form class="form-schedule-sms" role="form" action="sms.php" method="post">
				<fieldset>
					To: <input type="text" name="to" placeholder="(212) 000-0000"><br />
					From: <input type="text" name="from" placeholder="(212) 111-1111"><br />
					Message: <textarea maxlength="140" name="message"></textarea><br />
					Date: <input type="text" id="date" name="date"><br />
                    Hour: <select id="hour" name="hour">
                            <option value="00" selected="selected">00</option>
                            <option value="01" >01</option>
                            <option value="02" >02</option>
                            <option value="03" >03</option>
                            <option value="04" >04</option>
                            <option value="05" >05</option>
                            <option value="06" >06</option>
                            <option value="07" >07</option>
                            <option value="08" >08</option>
                            <option value="09" >09</option>
                            <option value="10" >10</option>
                            <option value="11" >11</option>
                            <option value="12" >12</option>
                            <option value="13" >13</option>
                            <option value="14" >14</option>
                            <option value="15" >15</option>
                            <option value="16" >16</option>
                            <option value="17" >17</option>
                            <option value="18" >18</option>
                            <option value="19" >19</option>
                            <option value="20" >20</option>
                            <option value="21" >21</option>
                            <option value="22" >22</option>
                            <option value="23" >23</option>
                        </select>
                    Minute: <select id="minute" name="minute">
                            <option value="00" selected="selected">00</option>
                            <option value="01" >01</option>
                            <option value="02" >02</option>
                            <option value="03" >03</option>
                            <option value="04" >04</option>
                            <option value="05" >05</option>
                            <option value="06" >06</option>
                            <option value="07" >07</option>
                            <option value="08" >08</option>
                            <option value="09" >09</option>
                            <option value="10" >10</option>
                            <option value="11" >11</option>
                            <option value="12" >12</option>
                            <option value="13" >13</option>
                            <option value="14" >14</option>
                            <option value="15" >15</option>
                            <option value="16" >16</option>
                            <option value="17" >17</option>
                            <option value="18" >18</option>
                            <option value="19" >19</option>
                            <option value="20" >20</option>
                            <option value="21" >21</option>
                            <option value="22" >22</option>
                            <option value="23" >23</option>
                            <option value="24" >24</option>
                            <option value="25" >25</option>
                            <option value="26" >26</option>
                            <option value="27" >27</option>
                            <option value="28" >28</option>
                            <option value="29" >29</option>
                            <option value="30" >30</option>
                            <option value="31" >31</option>
                            <option value="32" >32</option>
                            <option value="33" >33</option>
                            <option value="34" >34</option>
                            <option value="35" >35</option>
                            <option value="36" >36</option>
                            <option value="37" >37</option>
                            <option value="38" >38</option>
                            <option value="39" >39</option>
                            <option value="40" >40</option>
                            <option value="41" >41</option>
                            <option value="42" >42</option>
                            <option value="43" >43</option>
                            <option value="44" >44</option>
                            <option value="45" >45</option>
                            <option value="46" >46</option>
                            <option value="47" >47</option>
                            <option value="48" >48</option>
                            <option value="49" >49</option>
                            <option value="50" >50</option>
                            <option value="51" >51</option>
                            <option value="52" >52</option>
                            <option value="53" >53</option>
                            <option value="54" >54</option>
                            <option value="55" >55</option>
                            <option value="56" >56</option>
                            <option value="57" >57</option>
                            <option value="58" >58</option>
                            <option value="59" >59</option>
                        </select>
                    <input type="hidden" name="ip" value="<?php echo $ip ?>" />
					<button class="btn btn-lg btn-success btn-block" type="submit">Submit</button>
				</fieldset>
			</form>
		</div> <!-- /container -->
	
		<?php include 'footer.php'; ?>
	</body>
</html>
