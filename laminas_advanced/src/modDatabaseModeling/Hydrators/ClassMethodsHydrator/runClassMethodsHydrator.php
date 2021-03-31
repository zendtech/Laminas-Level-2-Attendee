<?php
/**
 * Runtime
 */
use src\modDatabaseModeling\Hydrators\ClassMethodsHydrator\UserEntity;
use Laminas\Hydrator\ClassMethodsHydrator;
require __DIR__ . '/../../../../vendor/autoload.php';
$hydrator = new ClassMethodsHydrator();
$userEntity = $hydrator->hydrate([
    'id' => 25,
    'firstName' => 'Mark',
    'lastName' => 'Watney',
    'password' => '12345'
],
    new UserEntity()
);

var_dump($userEntity);
