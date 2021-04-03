<?php
/**
 * Code Runner
 */
require __DIR__ . '/../../../vendor/autoload.php';
use Zend\Session\{Container, Config\SessionConfig, SessionManager, Storage\ArrayStorage};

// first request:
$container = new Container('my_app');
$container->foo = 'bar';

// next request:
$container = new Container('my_app');
if (isset($container->foo)) {
    echo $container->foo;
}

$manager = new SessionManager(
    new SessionConfig([
        'remember_me_seconds' => 900,
        'name' => 'zf2'
    ]),
    new ArrayStorage()
);
Container::setDefaultManager($manager);
