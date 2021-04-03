<?php
/**
 * Runtime
 */
use src\modDatabaseModeling\Hydrators\ObjectPropertyHydrator\UserEntity;
use Zend\Hydrator\ObjectPropertyHydrator;
require __DIR__ . '/../../../../vendor/autoload.php';
$hydrator = new ObjectPropertyHydrator();
$userEntity = $hydrator->hydrate([
    'id' => 25,
    'firstName' => 'Mark',
    'lastName' => 'Watney',
    'password' => '12345'
],
    new UserEntity()
);

printf('First name: %s / password: %s', $userEntity->firstName, $userEntity->password);