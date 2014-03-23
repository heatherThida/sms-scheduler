<?php
/**
 * Class Database
 *
 * Creates a PDO connection that will be passed into models. This helps pass same
 * database connection for all  models and prevent opening multiple connections at once.
 */

class Database extends PDO
{
    /**
     * Constructor
     *
     * Create a PDO instance representing a connection to a database
     */
    public function __construct()
    {
        // Set the options parameter for the PDO connection.
        $options = array(
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
        );

        // Generate a database connection using the PDO connector
        parent::__construct(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS, $options);
    }
} 