<?php
/**
 * Runtime
 */
require __DIR__ . '/../../../vendor/autoload.php';
define('TABLE_NAME', 'users');
use src\modDatabaseModeling\HydratingResultSet\UserEntity;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\Adapter\Adapter;

$config    = require __DIR__ . '/../../config/config.php';
$tableGateway     = new TableGateway(
    TABLE_NAME,
    new Adapter($config['db']),
    null,
    new HydratingResultSet(
        new ClassMethodsHydrator(),
        new UserEntity()
    )
);
$result    = $tableGateway->select();
foreach ($result as $user) var_dump($user);
