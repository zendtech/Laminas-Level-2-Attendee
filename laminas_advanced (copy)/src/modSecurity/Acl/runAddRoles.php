<?php
/**
 * Code Runner
 */
use Zend\Permissions\Acl\{Acl, Role\GenericRole};
require __DIR__ . '/../../../vendor/autoload.php';
$acl = new Acl();

// Add as a string
$acl->addRole('guest');

//Add as an object
$acl->addRole(new GenericRole('guest'));

// Add using single inheritance: "user" inherits from "guest"
// "editor" inherits from "user" (and thus also from "guest")
$acl->addRole('guest')->addRole('user', 'guest')->addRole('editor', 'user');

// Multiple inheritance: "manager" inherits "sales", "accounting" and "tech-support"
$acl->addRole('sales')
    ->addRole('accounting')
    ->addRole('tech-support')
    ->addRole('manager', ['sales', 'accounting', 'tech-support']);
