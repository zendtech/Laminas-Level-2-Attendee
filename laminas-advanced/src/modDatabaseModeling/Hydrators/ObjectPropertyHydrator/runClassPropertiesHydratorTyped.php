<?php
/**
 * Runtime
 */
use src\modDatabaseModeling\Hydrators\ObjectPropertyHydrator\UserEntityTyped;
use Laminas\Hydrator\ObjectPropertyHydrator;
require __DIR__ . '/../../../../vendor/autoload.php';
$hydrator = new ObjectPropertyHydrator();
$userEntity = $hydrator->hydrate([
    'id' => 25,
    'firstName' => 'Mark',
    'lastName' => 'Watney',
    'password' => '12345'
],
    new UserEntityTyped()
);

printf('First Name: %s / Last Name: %s', $userEntity->firstName, $userEntity->lastName);
