<?php
/**
 * Runtime
 */
require __DIR__ . '/../../../vendor/autoload.php';
define('TABLE_NAME', 'users');
use src\modDatabaseModeling\HydratingResultSet\UserEntity;
use Zend\Hydrator\ClassMethodsHydrator;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

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
foreach ($result as $user) Zend\Debug\Debug::dump($user);
