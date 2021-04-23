<?php
/**
 * Code Runner
 */
use Laminas\Db\Adapter\Adapter;
use Laminas\Log\Logger;
use Laminas\Log\Writer\Db;

require __DIR__ . '/../../../vendor/autoload.php';
$config = require __DIR__ . '/../../config/config.php';

// Initialise and write an informational message to the database
$writer = new Db(new Adapter($config['db']), 'log');
$logger = new Logger();
$logger->addWriter($writer);
$logger->info('Informational Message');

$pos = 0;
$dsn = 'mysql:host=localhost;dbname=zfcourse';
$pdo = new PDO($config['db']['dsn'], $config['db']['username'], $config['db']['password']);
$stmt = $pdo->query('SELECT * FROM log');
echo '<pre>';
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if ($pos++ === 0)
        echo implode(array_keys("\t", $row)) . "\n";
    echo implode("\t", $row) . "\n";
}
echo '</pre>';
