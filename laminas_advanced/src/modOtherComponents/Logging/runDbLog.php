<?php
/**
 * Code Runner
 */
use Laminas\Db\Adapter\Adapter;
use Laminas\Log\Logger;
use Laminas\Log\Writer\Db;

require __DIR__ . '/../../../vendor/autoload.php';
$config = require '../../config/config.php';

// Initialise and write an informational message to the database
$writer = new Db(new Adapter($config['db']), 'log');
$logger = new Logger();
$logger->addWriter($writer);
$logger->info('Informational Message');

