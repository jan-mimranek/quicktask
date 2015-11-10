<?php
ini_set('display_errors', '-1');     # don't show any errors...
error_reporting(E_ALL);
// Uncomment this line if you must temporarily take down your site for maintenance.
// require '.maintenance.php';

$container = require __DIR__ . '/../app/bootstrap.php';

$container->getService('application')->run();
