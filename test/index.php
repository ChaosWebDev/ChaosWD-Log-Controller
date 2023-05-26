<?php
if (!date_default_timezone_get()) {
    date_default_timezone_set('America/Denver');
}

require(__DIR__ . "/../vendor/autoload.php");

use ChaosWD\Controller\LogController;

$logger = new LogController(__DIR__ . "/logs", "test_log");
$bonusLog = new LogController(__DIR__ . "/logs", "bonus_log");

//$logger->log(3); // * Should give an error log for invalid type * //
// * Success: [Timestamp: 05/26/2023 1432][Message: Attempted to log non-array/non-class variable][Data: 3]

$obj = new stdClass();
$obj->message = "Test Message";               // * Successfully failed when `message` was not set
$obj->reason = "Testing";                     // * Successfully failed when `reason` was not set
// $obj->data = ["test"=>"array test"];          // * Successfully showed as a json_encoded array
// $obj->data = new stdClass();                  // * Successfully showed as a json_encoded object
// $obj->data->pizza = "Pizza";                  // * Nested Objects worked
// $obj->data->drinks = "Dr Awesome";            // * Nested Objects worked
// $obj->data = null;                            // * Successfully sexcludes 'Data"
// * Lack of definition of `$obj->data` also is Successful

// $logger->log($obj);
$bonusLog->log($obj);

// * Having two logs at the same time did not cause any issues