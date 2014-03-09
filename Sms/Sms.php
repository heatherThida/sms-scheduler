<?php
/*
 * TODO: Comments on the class
 *
 * It may be a bit of an overkill to have a class just to send SMS.
 * But the idea is to be able to swap out the underlying API or library
 * without having any major effects. Or to allow people who prefer something
 * other than Twilio to use that instead.
 *
 */

@include_once('../includes/config.php');
@include_once('../lib/twilio-php/Services/Twilio.php');

class Sms
{
    private $apiKey;
    private $apiSecret;
    private $fromNumber;

    private $client;

    /*
     * @param string $dbHost
     * @param string $dbUser
     * @param string $dbPass
     * @param string $dbName
     * @param string @dbPort
     */
    public function __construct()
    {
        $this->apiKey       = TWILIO_SID;
        $this->apiSecret    = TWILIO_TOKEN;
        $this->fromNumber   = TWILIO_NUMBER;

        $this->client = new Services_Twilio(TWILIO_SID, TWILIO_TOKEN);

        //return $client;

    }
    /*
     * @param array - an array with sms data
     *
     */
    public function send($sms) {
        echo "Inside send function..\n";
        //print_r($sms);
        $db = new Database();

        echo "Beginning foreach loop..\n";
        foreach($sms as $key => $singleSms) {
            //print_r($singleSms['to_number']);

            try {
                $twilioResponse = $this->client->account->messages->sendMessage(
                    $this->fromNumber,      // From a valid Twilio Number
                    $singleSms['to_number'],    // Text this number
                    $singleSms['message'],
                    array(
                        'StatusCallback' => TWILIO_STATUS_CALLBACK_URL      // Defined in config file
                    )
                );
            } catch (Services_Twilio_RestException $e) {
                echo $e->getMessage();
            }

            // Get response from Twilio in json format and convert to array
            $twilioResponse = json_decode($twilioResponse->__toString(), true);
            print_r($twilioResponse);

            // Save Twilio Sid in database
            $db->saveTwilioResponse($singleSms['id'], $twilioResponse);

            //print_r($twilioResponse);
        }

        //return $twilioResponse;
    }
}