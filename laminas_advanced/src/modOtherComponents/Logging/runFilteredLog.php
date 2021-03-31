<?php
/**
 * Code Runner
 */
require __DIR__ . '/../../../vendor/autoload.php';
use Laminas\Log\{Filter\Priority, Logger, Writer\Stream, Writer\Syslog};

$logFile = 'example.log';
$logger = new Logger;
$fp = fopen(__DIR__ . '/' . $logFile, 'w+');
$writerStream = new Stream($fp);

$logger->addWriter($writerStream);
$writerSysLog = new Syslog();
$filter = new Priority(Logger::ALERT);
$writerSysLog->addFilter($filter);
$logger->addWriter($writerSysLog);

// Logs to both destinations
$logger->log(Logger::INFO, 'Informational message');

// Logs to the Syslog
$logger->log(Logger::ALERT, 'Emergency message');

echo file_get_contents($logFile);
