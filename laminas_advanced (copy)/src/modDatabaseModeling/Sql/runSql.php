<?php
/**
 * Runtime
 */
use src\modDatabaseModeling\Sql\RegistrationTable;
use Zend\Db\Adapter\Adapter;
require __DIR__ . '/../../../vendor/autoload.php';
$config = require '../../config/config.php';
$registrationTable = new RegistrationTable(new Adapter($config['db']));
$results = $registrationTable->findAllForEvent(1);
var_dump($results);