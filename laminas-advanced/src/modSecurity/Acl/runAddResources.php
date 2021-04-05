<?php
/**
 * Code Runner
 */
use Laminas\Permissions\Acl\{Acl, Resource\GenericResource};
require __DIR__ . '/../../../vendor/autoload.php';
$acl = new Acl();

// Add as a string
$acl->addResource('index-controller');

// or a object instance
$acl->addResource(new GenericResource('index-controller'));

// Resources only support single inheritance
$acl->addResource('index-controller')
    ->addResource('view-controller', 'index-controller');