<?php
/**
 * Code Runner
 */
require __DIR__ . '/../../../vendor/autoload.php';
use Zend\Log\{Logger, Writer\Stream};

$logFile = 'example.log';
$logger = new Logger;
$fp = fopen(__DIR__ . '/' . $logFile, 'w+');
$writer = new Stream($fp);
$logger->addWriter($writer);

// log a message
$logger->log(Logger::INFO, 'Informational message');

echo file_get_contents($logFile);