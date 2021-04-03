<?php
/**
 * ${NAME}
 */
use Zend\Db\Adapter\Adapter;
require __DIR__ . '/../../../vendor/autoload.php';
$config = require '../../config/config.php';

try {
    // Assumes $adapter instanceof Zend\Db\Adapter\Adapter
    $adapter = new Adapter($config['db']);
    $connection = $adapter->getDriver()->getConnection();
    // force the database connection
    $connection->connect();
    // process a transaction
    $connection->beginTransaction();
    // ... some database operations ...
    $connection->commit();
} catch (Throwable $e) {
    // log error
    $connection->rollback();
}
