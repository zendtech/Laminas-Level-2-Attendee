<?php
/**
 * Code Runner
 */
require __DIR__ . '/../../../vendor/autoload.php';
use Laminas\Log\{Logger, Writer\Stream};

$logFile = 'example.log';
$logger = new Logger;
$fp = fopen(__DIR__ . '/' . $logFile, 'w+');
$writer = new Stream($fp);
$logger->addWriter($writer);

// log a message
$logger->log(Logger::EMERG, 'EMERGENCY message');

echo '<pre>';
echo file_get_contents($logFile);
echo '</pre>';
