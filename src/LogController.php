<?php

namespace ChaosWD\Controller;

use stdClass;

class LogController
{
    public $loc, $id, $filePath;

    public function __construct($loc, $id)
    {
        date_default_timezone_set($_ENV['TIMEZONE'] ?? $_SESSION['TIMEZONE'] ?? $_COOKIE['TIMEZONE'] ?? 'America/Denver');

        $this->loc = $loc;
        $this->id = $id;

        if (!is_dir($this->loc)) {
            mkdir($this->loc, 0755);
        }

        $this->filePath = $this->loc . "/" . $this->id . ".log";

        if (!file_exists($this->filePath)) {
            $time = date("m/d/Y Hi", time());
            $entryLine = "[Created On: {$time}]\r\n";

            $file = fopen($this->filePath, "w+");
            fwrite($file, $entryLine);
            fclose($file);
        }
    }

    public function log($error)
    {
        if (!is_array($error) && !is_object($error)) {
            $data = $error;
            unset($error);
            $error = new stdClass();
            $error->reason = "ErrorHandling";
            $error->message = "Attempted to log non-array/non-class variable";
            $error->data = $data;
        }

        if (!isset($error->reason) || $error->reason == null || $error->reason == "") {
            $data = $error;
            unset($error);
            $error = new stdClass();
            $error->reason = "ErrorHandling";
            $error->message = "Missing `reason`";
            $error->data = [$data->message];
        }

        if (!isset($error->message) || $error->message == null || $error->message == "") {
            unset($error);
            $error = new stdClass();
            $error->reason = "ErrorHandling";
            $error->message = "Log Message is null";
        }

        $error = json_decode(json_encode($error), false); // * ENSURE IT COMES OUT AN OBJECT * //

        $error->timestamp = date("m/d/Y Hi", time());
        $log = "[Timestamp: {$error->timestamp}]";
        $log .= "[Reason: {$error->reason}]";
        $log .= "[Message: {$error->message}]";
        $log .= "[IP: {$_SERVER['REMOTE_ADDR']}]";

        if (isset($error->data)) {
            $data = json_encode($error->data);
        } else {
            $data = "";
        }

        if (isset($data) && $data !== null && $data !== "") {
            print_r($data);
            $log .= "[Data: {$data}]";
        }

        $log .= "\r\n";
        file_put_contents($this->filePath, $log, FILE_APPEND);
    }
}
