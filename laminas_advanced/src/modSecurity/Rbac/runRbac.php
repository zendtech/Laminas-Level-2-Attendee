<?php
/**
 * Code Runner
 */
use Laminas\Permissions\Rbac\{Rbac, Role};
require __DIR__ . '/../../../vendor/autoload.php';
$guestRole = new Role('guest');
$guestRole->addPermission('login');

$userRole = new Role('user');
$userRole->addPermission('post');

$bossRole = new Role('boss');
$bossRole->addPermission('order');

$rbac = new Rbac();

// guest can login
$rbac->addRole($guestRole);
// user can login and post
$rbac->addRole($userRole, $guestRole);
// boss can login, post, and order people around
$rbac->addRole($bossRole, $userRole);
