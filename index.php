<?php

/**
 * A simple app to schedule SMS messages
 *
 * @package sms-scheduler
 * @author Kojoman
 * @link https://github.com/kojoman/sms-scheduler
 */

// Load application config file
require 'app/config/config.php';


// Load auto-loader
require 'app/config/autoload.php';

// Composer auto-loader
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}

// Start the application
$app = new Application();