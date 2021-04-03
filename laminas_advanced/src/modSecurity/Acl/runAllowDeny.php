<?php
/**
 * Code Runner
 */
use Zend\Permissions\Acl\Acl;
require __DIR__ . '/../../../vendor/autoload.php';
$acl = new Acl();
$acl->addRole('guest')
    ->addRole('admin')
    ->addRole('user', 'guest')
    ->addResource('index-controller')
    ->addResource('view-controller', 'index-controller');

// Allow "guest" role rights to all index controller action
$acl->allow('guest', 'index-controller', NULL);

// allow "user" role rights to view controller item action
$acl->allow('user', 'view-controller', 'item');

// deny "guest" role rights to admin controller
$acl->deny('guest', 'admin-controller', NULL);

// allow "admin" role rights to all controllers and actions
$acl->allow('admin', NULL, NULL);
// or
$acl->allow('admin');
