<?php
/**
 * Code Runner
 */
require __DIR__ . '/../../../vendor/autoload.php';
use Zend\Debug\Debug;
use Zend\Log\{Logger, Writer\Stream};

$logFile = 'example.log';
$logger = new Logger;
$fp = fopen(__DIR__ . '/' . $logFile, 'w+');
$writer = new Stream($fp);
$logger->addWriter($writer);

// log a debug message of the contents of variable $data
$data = ['name' => 'Mark'];
$logger->debug(Debug::dump($data, 'This Becomes the Label', false));
echo file_get_contents($logFile);