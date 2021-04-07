<?php
/**
 * Runtime
 */
use src\modDatabaseModeling\Sql\RegistrationTable;
use Laminas\Db\Adapter\Adapter;
require __DIR__ . '/../../../vendor/autoload.php';
$config = require '../../config/config.php';
$registrationTable = new RegistrationTable(new Adapter($config['db']));
$results = $registrationTable->findAllForEvent(1);
$patt = "%2s : %2s : %8s : %12s : %20s : %2s : %s\n";
foreach ($results as $obj) vprintf($patt, $obj->getArrayCopy());
