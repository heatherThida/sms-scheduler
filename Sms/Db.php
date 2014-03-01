<?php
/*
 * TODO: Comments on the class
 *
 * Inspiration taken from the following:
 *  - git@github.com:ajillion/PHP-MySQLi-Database-Class.git
 *
 */

//include_once('../includes/config.php');

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

//    // Array to store data
//        $sms_data = array(
//        'status' => 'pending' ,
//        'from_number' => $from,
//        'to_number' => $to,
//        'message' => $message,
//        'sms_scheduled_day' => $day,
//        'sms_scheduled_month' => $month,
//        'sms_scheduled_year' => $year,
//        'sms_scheduled_hour' => $hour,
//        'sms_scheduled_minute' => $minute,
//        'ip' => $ip,
//        'scheduled_at' => time(),
//        );
//
//        $db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
//
//        // Check connection
//        if ($db->connect_errno) {
//        echo "Failed to connect to MySQL: (" . $db->connect_errno . ") ";
//        exit;
//        }
//
//        $sql = "INSERT INTO log
//                (status, from_number, to_number, message, sms_scheduled_time,
//                sms_scheduled_day, sms_scheduled_month, sms_scheduled_year,
//                sms_scheduled_hour, sms_scheduled_minute, ip)
//                VALUES
//                ('pending', '$from', '$to', '$message', '$scheduled_time', '$day', '$month', '$year', '$hour', '$minute', '$ip');";
//
//        $insertData = $db->query($sql);
//
//        if ($insertData) {
//            echo "Data has been successfully inserted.\n";
//        } else {
//            echo "Oops, could not insert data.<br />\n";
//            echo $db->error;
//        }
//
//        // Close MySQL connection
//        $db->close();
//
//
    /*
     * Save data from form into database
     *
     * @param string $tableName - Table to insert data into
     * @param array $data       - Data to be saved in associative array format
     */
    public function savePostData($tableName, $data)
    {

        //$to, $from, $message, $date, $hour, $minute, $ip;

        $validatedData = $this->validatePostData($data);

        if (($validatedData['success']) == FALSE) {
            //print_r($validatedData['errors']);
            //return $validatedData['errors'];
        } else {
            echo "Data validated..\n";
        }


        //$keys = "`" . implode("`, `", $this->getTableColumnNamesAsArray()) . "`";
        $keys = "`" . implode("`, `", array_keys($this->prepareDataForDatabase($validatedData))) . "`";
        unset($validatedData['errors']);
        $values = "'" . implode("', '", $this->prepareDataForDatabase($validatedData)) . "'";

        $query = "INSERT INTO `{$tableName}` ({$keys}) VALUES ({$values})";

       print_r($keys);
        echo "\n";
        print_r($values);

        print_r($this->getTableColumnNamesAsArray());

        @print_r($this->prepareDataForDatabase($validatedData));

        print_r($query);

        $x = $this->_mysqli->query($query);

        print_r($x);

    }

    /*
     * Validate $data data sent via form
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

        if (empty($data["hour"])) {
            $errors['hour'] = 'Hour is required.';
        }

        if (empty($data["minute"])) {
            $errors['minute'] = 'Minute is required.';
        }

        if ( !empty($errors)) {
            // Return errors
            $data['success'] = false;
            $data['errors'] = $errors;
        } else {
            $data['success'] = true;
            $data['message'] = 'Success';
        }

        //$data['errors'] = $errors;

        // convert errs to json
       // $errors = json_encode($errors);

        // convert data to json
        //$data = json_encode($data);

        // create an array to return
        $validatedData = array(
            'data'      => $data,
            'errors'    => $errors
        );

        return $data;
    }

    public function getTableColumnNamesAsArray() {
//        $query = "INSERT INTO log
//                (status, from_number, to_number, message, sms_scheduled_time,
//                sms_scheduled_day, sms_scheduled_month, sms_scheduled_year,
//                sms_scheduled_hour, sms_scheduled_minute, ip)
//                VALUES
//                ('pending', '$from', '$to', '$message', '$scheduled_time', '$day', '$month', '$year', '$hour', '$minute', '$ip');";

        $tableColNames = array(
            'status',
            'from_number',
            'to_number',
            'message',
            'sms_scheduled_time',
            'sms_scheduled_day',
            'sms_scheduled_month',
            'sms_scheduled_year',
            'sms_scheduled_hour',
            'sms_scheduled_minute',
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
            'sms_scheduled_day' => " ",
            'sms_scheduled_month' => '',
            'sms_scheduled_year' => '',
            'sms_scheduled_hour' => $data['hour'],
            'sms_scheduled_minute' => $data['minute'],
            'ip' => $data['ip']
        );

        return $preparedData;
    }


    public function getRows($tableName)
    {
        $query = "SELECT * FROM $tableName WHERE status = 'sent'";
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

//    public function getInstance()
//    {
//        return self::$_instance;
//    }
//
//    /*
//     * @param string $query
//     * @param int    $numRows
//     *
//     * @return array - the returned rows from the query.
//     */
//    public function query($query, $numRows = NULL)
//    {
//        $this->_query = filter_var($query, FILTER_SANITIZE_STRING);     // filters a variable with a specified filter
//        $statement = $this->_buildQuery($numRows);
//        $statement->execute();
//        $this->reset();
//
//        return $this->_dynamicBindResults($statement);
//    }

    /*
     * A convenient SELECT * function
     *
     * @param string $tableName
     * @param integer $numRows
     *
     * @return array - the returned rows from select query
     */
//    public function get($tableName, $numRows = null, $columns = '*')
//    {
//        if (empty ($columns)) {
//            $columns = '*';
//        }
//
//        $columns = is_array($columns) ? implode(', ', $columns) : $columns;
//        $this->_query = "SELECT $column FROM $tableName";
//        $statement = $this->_buildQuery($numRows);
//        $statement->execute();
//        $this->reset();
//
//        return this->_dynamicBindResults($stmt);
//    }
//
//    public function getSmsById($id) {
//
//
//    }

//    public function __destruct()
//    {
//        // Close MySQL connection
//        $this->_mysqli->close();
//    }
}