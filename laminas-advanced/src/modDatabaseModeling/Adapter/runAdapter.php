<?php
/**
 * ${NAME}
 */
use Laminas\Db\Adapter\Adapter;
require __DIR__ . '/../../../vendor/autoload.php';
$config = require '../../config/config.php';
try {
    // Assumes $adapter instanceof Laminas\Db\Adapter\Adapter
    $adapter = new Adapter($config['db']);
    $connection = $adapter->getDriver()->getConnection();
    // force the database connection
    $connection->connect();
    // process a transaction
    $connection->beginTransaction();
    // run one or more SQL commands
    $result = $connection->execute('SELECT * FROM event');
    // all OK
    $connection->commit();
    // do something else
    echo get_class($result) . ":\n";
    foreach ($result as $obj) var_dump($obj);
} catch (Throwable $e) {
    // log error + rollback
    error_log(get_class($e) . ':' . $e->getMessage());
    $connection->rollback();
}
