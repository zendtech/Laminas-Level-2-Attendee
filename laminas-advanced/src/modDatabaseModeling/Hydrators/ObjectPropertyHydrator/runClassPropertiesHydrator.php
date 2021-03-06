<?php
/**
 * Runtime
 */
use src\modDatabaseModeling\Hydrators\ObjectPropertyHydrator\UserEntity;
use Laminas\Hydrator\ObjectPropertyHydrator;
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

printf("First Name: %s / Last Name: %s\n", $userEntity->firstName, $userEntity->lastName);
