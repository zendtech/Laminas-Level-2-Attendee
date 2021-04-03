<?php
/**
 * Runtime
 */
use src\modDatabaseModeling\Hydrators\ArraySerializableHydrator\UserEntity;
use Zend\Hydrator\ArraySerializableHydrator;
require __DIR__ . '/../../../../vendor/autoload.php';
$hydrator = new ArraySerializableHydrator();
$userEntity = $hydrator->hydrate([
    'id' => 25,
    'firstName' => 'Mark',
    'lastName' => 'Watney',
    'email' => 'mwatney@nasa.gov',
    'password' => '12345',
],
    new UserEntity()
);

var_dump($userEntity);