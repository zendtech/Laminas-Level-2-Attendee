<?php
/**
 * Runtime
 */
use src\modDatabaseModeling\Hydrators\ReflectionHydrator\UserEntity;
use Laminas\Hydrator\ReflectionHydrator;
require __DIR__ . '/../../../../vendor/autoload.php';
$hydrator = new ReflectionHydrator();
$userEntity = $hydrator->hydrate([
    'id' => 25,
    'firstName' => 'Mark',
    'lastName' => 'Watney',
    'password' => '12345'
],
    new UserEntity()
);

var_dump($userEntity);
