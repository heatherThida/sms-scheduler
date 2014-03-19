<?php

/**
 * Class Home
 */

class Home extends Controller
{
    /**
     * PAGE: index
     * Handle http://url/home/index
     */
    public function index()
    {
        // Debug message
        echo "You are in controller home, using method index()";

        // Load views
        require 'app/views/_templates/header.php';
        require 'app/views/home/index.php';
        require 'app/views/_templates/footer.php';
    }
}