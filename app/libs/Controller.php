<?php

/**
 * Base Controller Class
 */

class Controller
{
    /**
     * Constructor
     */
    function __construct()
    {
        //Session::init();

        // Login user with cookie if 'remember-me' cookie isset
        if (!isset($_SESSION['user_logged_in']) && isset($_COOKIE['rememberme'])) {
            header('location: ' . URL . 'login/loginWithCookie');
        }

        // Connect to database
        try {
            $this->db = new Database();
        } catch (PDOException $e) {
            die('Database connection could not be established');
        }

        // Create new view object
        $this->view = new View();

    }

    /**
     * Load the model with the given name
     *
     * @param $modelName String
     */
    public function loadModel($name)
    {
        $path = MODELS_PATH . strtolower($name) . '_model.php';

        if (file_exists($path)) {
            require MODELS_PATH . strtolower($name) . '_model.php';

            $modelName = $name . 'Model';

            // Return the new model object while passing the database connection to the model
            return new $modelName($this->db);
        }

//        require 'app/models/' . strtolower($name) . '.php';
//
//        return new $modelName();
    }
}