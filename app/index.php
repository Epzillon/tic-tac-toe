<?php

use App\Core\Mvc;

require_once('vendor/autoload.php');

$routeProcessor = new Mvc();
$routeProcessor->processCurrentRequest();
