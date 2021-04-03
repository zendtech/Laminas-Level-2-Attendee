<?php
/**
 * Code Runner
 */
require __DIR__ . '/../../../vendor/autoload.php';
use Laminas\Log\{Filter\Priority, Logger, Processor\ReferenceId, Writer\Stream};

$logFile = 'example.log';
$logger = new Logger;
$fp = fopen(__DIR__ . '/' . $logFile, 'w+');
$writerStream = new Stream($fp);
$logger->addWriter($writerStream);
$processor = new ReferenceId();
$processor->setReferenceId(microtime(true) . '_' . uniqid());
$logger->addProcessor($processor);

// Logs to both destinations
$logger->log(Logger::INFO, 'Additional information message');

echo file_get_contents($logFile);
