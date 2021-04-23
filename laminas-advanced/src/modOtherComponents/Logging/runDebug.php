<?php
/**
 * Code Runner
 */
require __DIR__ . '/../../../vendor/autoload.php';
use Laminas\Debug\Debug;
use Laminas\Log\{Logger, Writer\Stream};

$logFile = 'example.log';
$logger = new Logger;
$fp = fopen(__DIR__ . '/' . $logFile, 'w+');
$writer = new Stream($fp);
$logger->addWriter($writer);

// log a debug message of the contents of variable $data
$data = ['name' => 'Mark'];
$logger->debug(var_export($data, TRUE));
echo '<pre>';
echo file_get_contents($logFile);
echo '</pre>';
