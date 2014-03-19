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

// Load application class
require 'app/libs/application.php';
require 'app/libs/controller.php';

// Start the application
$app = new Application();