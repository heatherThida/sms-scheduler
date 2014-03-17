<?php

include('../includes/config.php');

/*
 * Class to schedule SMS
 */

class SmsScheduler
{


    public function getSmsScheduledForNextFiveMinutes($tableName = 'log')
    {

        /*
         * Each row has a scheduled time
         * Get current time + 5 minutes = time
         * Return all rows with scheduled time < time
         */
        $timeInterval = time() + 5;

        $dateTime = new DateTime();
        $dateTime->format('Y-m-d H:i:s');
        $nextFiveMinutes = $dateTime->add(new DateInterval('PT5M'))->getTimestamp();

        echo $nextFiveMinutes;

        //print_r($nextFiveMinutes->getTimestamp());


        $smsToSend = array();

        //$query = "SELECT * FROM $tableName WHERE `scheduled_datetime` < $nextFiveMinutes->getTimestamp() ";
        //$query = "SELECT * FROM $tableName WHERE `scheduled_datetime`> $nextFiveMinutes";
        //$query = "SELECT `scheduled_datetime` FROM $tableName";
        $query = "SELECT * FROM $tableName WHERE TIMESTAMPDIFF(MINUTE, NOW(), `scheduled_datetime`) > 5";

        //print_r($query);

        $result = $this->_mysqli->query($query);

        //print_r($result);

        if ($result) {
            // fetch object array
            while ($row = $result->fetch_array(MYSQL_ASSOC)) {
                //print_r($row);
                $smsToSend[] = $row;
            }
            $result->close();
        }

        $this->_mysqli->close();

        //print_r($smsToSend);

        return $smsToSend;

    }

    private $scheduledTime;

    public function readDatabase()
    {

    }

    public function getScheduledTime()
    {

    }

    /*
     *
     */
    public function getScheduledMessages()
    {

    }

    public function getSmsfromDb()
    {

    }
}