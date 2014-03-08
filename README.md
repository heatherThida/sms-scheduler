# SMS Scheduler

## About
This is a simple script to help schedule sms and send them at a specified time in the future.
Twilio's API is used to send the SMS so you'll need an API key and secret as well as a Twilio number to use this.

## Installation
To run this locally, you'll need to clone the site, set up a database and add the credentials to /includes/config.php.
Also, you'll need to set up a cron job to run every five minutes so that it picks up the sms to send.

## Current Status
It's currently in pre-alpha stage and would need a lot more to get to alpha or beta. Pull requests are certainly welcome.