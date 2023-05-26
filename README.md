Install:
````
composer require chaoswd/log_controller
````

Instantiate:
````
use ChaosWD\Controller\LogController;
$logger = new LogController(__DIR__ . "/path/to/logs", "log_name");
````
You can set as many different log files as you want, you just have to instantiate the class for each one.<br>

To Log:
````
$logger->log([$data]);
````
The data should be an associative array or an object.
<br><br>
Required Keys/Properties:
<ul>
<li>$obj->reason</li>
<li>$obj->message</li>
</ul>
Additional Possible Keys/Properties:
<ul>
<li>$obj->data (must be an array, object, or null). You can set whatever you want in here.</li>
</ul>
Timezone --<br>
The default Timezone is set to 'America/Denver' (AKA: US Mountain Time). To change this, have one of the following set:<br>
<ul>
<li>$_ENV['TIMEZONE']</li>
<li>$_SESSION['TIMEZONE']</li>
<li>$_COOKIE['TIMEZONE']</li>
</ul>
As long as one of these are set (priority is in that order, with $_ENV being highest priority), then the system should take your timezone for the logs.