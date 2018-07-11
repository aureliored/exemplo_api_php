<?php
// ini_set('memory_limit', '1024M');
define('__APP_ROOT__', dirname(__DIR__) . '\exemplo_api_php');
require __APP_ROOT__ . '\vendor\autoload.php';

use Application\Application; 


$app = new Application();
$app->init()
    ->start();
