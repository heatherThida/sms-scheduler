<?php

/**
 * Command line tool to install sms-scheduler
 *
 * Usage:
 *  cd $this_directory
 *  php cli_install.php install --db_hostname localhost \
 *                              --db_username root \
 *                              --db_password pass \
 *                              --db_database sms_scheduler \
 *                              --db_driver   mysqli
 */

if (version_compare(phpversion(), '5.3.0', '<') === true) {
    die('ERROR: Sorry Sms-Scheduler only supports PHP 5.3.0 or newer.');
}