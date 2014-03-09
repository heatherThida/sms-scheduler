<?php
/*
 * TODO: Comments on the class
 *
 * Inspiration taken from the following:
 *  - git@github.com:ajillion/PHP-MySQLi-Database-Class.git
 *
 */

@include_once('../includes/config.php');

/*
 * Handle connection to Database here
 */

class Database
{

    /*
     * Static instance of self
     *
     * @var Database
     */
    protected static $_instance;

    /*
     * MySQLi instance
     *
     * @var mysqli
     */
    protected $_mysqli;


    private $dbHost;
    private $dbUser;
    private $dbPass;
    private $dbName;
    private $dbPort;
    private static $_connection = NULL;

    /*
     * @param string $dbHost
     * @param string $dbUser
     * @param string $dbPass
     * @param string $dbName
     * @param string @dbPort
     */
    public function __construct()
    {


        $this->dbHost = DBHOST;
        $this->dbUser = DBUSER;
        $this->dbPass = DBPASS;
        $this->dbName = DBNAME;
        if($this->dbPort == NULL) {
            $port = ini_get('mysqli.default_port');
            $this->dbPort = $port;
        }


        $this->_mysqli = new mysqli($this->dbHost, $this->dbUser, $this->dbPass, $this->dbName, $this->dbPort);

        if($this->_mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $this->_mysqli->connect_errno . ") " .$this->_mysqli->connect_error;
            die("There was a problem connecting to database...\n");

            $this->_mysqli->set_charset('utf8');

            self::$_instance = $this;
        }
        return $this->_mysqli;

    }

    public function createDatabase() {
        $query = "
                    CREATE TABLE IF NOT EXISTS `log`
                    (
                     id INT NOT NULL AUTO_INCREMENT,
                     status varchar(25),
                     from_number VARCHAR(255),
                     to_number VARCHAR(255),
                     message TEXT,
                     ip BIGINT(20),
                     api_response TEXT,
                     created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                     scheduled_datetime DATETIME,
                     sms_scheduled_time DATETIME,
                     scheduled_at TIMESTAMP,
                     executed_at TIMESTAMP,
                     finished_at TIMESTAMP,
                     PRIMARY KEY (id)
                    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
                ";

        $result = $this->_mysqli->query($query);

        if ($result) {
            echo "Table has been successfully created.\n";
            $result->close();
        } else {
            echo "Oops, could not create table.\n";
            echo $result->connect_error;
        }

        $this->_mysqli->close();
    }


    /*
     * Save data from form into database
     *
     * @param string $tableName - Table to insert data into
     * @param array $data       - Data to be saved in associative array format
     */
    public function savePostData($tableName, $data)
    {

        $validatedData = $this->validatePostData($data);

        if (($validatedData['success']) == FALSE) {
            //print_r($validatedData['errors']);
            return $validatedData['errors'];
        }

        debug($validatedData);

        $keys = "`" . implode("`, `", array_keys($this->prepareDataForDatabase($validatedData))) . "`";
        unset($validatedData['errors']);
        $values = "'" . implode("', '", $this->prepareDataForDatabase($validatedData)) . "'";

        echo "keys below:\n";
        debug($keys);
        echo "matching values below: \n";
        debug($values);

        $query = "INSERT INTO `{$tableName}` ({$keys}) VALUES ({$values})";

        debug($query);

        $savePostData = $this->_mysqli->query($query);

        return $savePostData;

    }

    /*
     * Re-validate $data data sent via form just to be safe
     *
     * @param array $data
     */
    public function validatePostData($data)
    {
        $errors         = array();      // Array to hold validation errors
       // $data           = array();      // Array to pass back data


        if (empty($data["to"])){
            $errors['to'] = 'Please enter a number to send to';
        }

        if (empty($data["from"])) {
            $errors['from'] = 'Please enter your cell phone number';
        }

        if (empty($data["message"])) {
            $errors['message'] = 'Sorry, an empty sms cannot be sent.';
        }

        if (empty($data["date"])) {
            $errors['date'] = 'Date is required.';
        }

        if ( !empty($errors)) {
            // Return errors
            $data['success'] = false;
            $data['errors'] = $errors;
        } else {
            $data['success'] = true;
        }

        // create an array to return
        $validatedData = array(
            'data'      => $data,
            'errors'    => $errors
        );

        return $data;
    }

    public function getTableColumnNamesAsArray() {

        $tableColNames = array(
            'status',
            'from_number',
            'to_number',
            'message',
            'sms_scheduled_time',
            'sms_scheduled_day',
            'sms_scheduled_month',
            'sms_scheduled_year',
            'ip'
        );

        return $tableColNames;
    }

    public function prepareDataForDatabase($data) {

        $preparedData = array(
            'status' => 'pending',
            'from_number' => $data['from'],
            'to_number' => $data['to'],
            'message' => $data['message'],
            'sms_scheduled_time' => time(),
            'scheduled_datetime' => $data['date'],
            'ip' => $data['ip']
        );

        return $preparedData;
    }


    public function getAllRows($tableName)
    {
        $query = "SELECT * FROM $tableName";
        $result = $this->_mysqli->query($query);

        if($result) {
            // fetch object array
            while ($row = $result->fetch_array(MYSQL_ASSOC)) {
                print_r($row);
                //printf("%s (%s)\n", $row[0], $row[3]);
            }


            $rows = $result->fetch_assoc();

            var_dump($rows);
//
//            print_r($this->_mysqli->query($query));

            // free result set
            $result->close();
        }

        $this->_mysqli->close();
    }

    /*
     * Return all messages that have not been sent and are scheduled for the next five minutes
     *
     * @return array
     */
    public function getSmsScheduledForNextFiveMinutes() {

        $smsToSend = array();

        //TODO: Double check the reference to 'NOW' and what time exactly is being used.
        $query =    "
                    SELECT `id`, `to_number`, `message`
                    FROM `log`
                    WHERE TIMESTAMPDIFF(MINUTE, NOW(), `scheduled_datetime`) < 5 && `status` = 'pending';
                    ";

        $result = $this->_mysqli->query($query);

        //print_r($result);

        if($result) {
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

    public function saveTwilioResponse($smsId, $twilioResponse, $tableName = 'log') {
        // parse and save meaningful response from twilio's api

        $twilioSID  = $twilioResponse['sid'];
        $status     = $twilioResponse['status'];

        $query =    "UPDATE $tableName
                    SET api_response='$twilioSID', status='$status'
                    WHERE id='$smsId'";

        print_r($query);

        $result = $this->_mysqli->query($query);

        echo "Mysql query inserting twilio response\n";
        print_r($result);
        echo "\n";
    }

    public function getSmsStatus() {
        // ping twilio with sms_id for status

        $tableName = 'log';

        $query = "SELECT `id`, `api_response`
                 FROM $tableName
                 WHERE `status`='queued'
                ";

        $result = $this->_mysqli->query($query);

        if($result) {
            // fetch object array
            while ($row = $result->fetch_array(MYSQL_ASSOC)) {
                //print_r($row);
                $smsToVerify[] = $row;
            }
            $result->close();
        }

        $this->_mysqli->close();

        print_r($smsToVerify);

    }


}