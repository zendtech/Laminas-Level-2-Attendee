<?php
/**
 * Code Runner
 */
use Laminas\Log\{Formatter\Xml, Logger, Writer\Stream};
require __DIR__ . '/../../../vendor/autoload.php';
$formatter = new Xml();

$logFile = 'example.log';
$logger = new Logger();
$fp = fopen(__DIR__ . '/' . $logFile, 'w+');
$writer = new Stream($fp);
$writer->setFormatter($formatter);
$logger->addWriter($writer);

// Log an informational message
$logger->log(Logger::INFO, 'Informational Message');
header('Content-Type: text/xml, application/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>'
    . '<root>'
    . file_get_contents($logFile)
    . '</root>';
