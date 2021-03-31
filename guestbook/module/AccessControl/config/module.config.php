<?php
namespace AccessControl;
use AccessControl\Listener\AclListenerAggregate;
use AccessControl\Assertion\Factory\DateTimeAssertFactory;
use AccessControl\Acl\Factory\GuestbookAclFactory;
return [
    'listeners' => [
        AclListenerAggregate::class,
    ],
    'service_manager' => [
        'factories' => [
            'access-control-datetime-assert' => DateTimeAssertFactory::class,
            'access-control-guestbook-acl' => GuestbookAclFactory::class,
        ],
    ],
    'access-control-config' => [
        'roles' => [
            'guest' => NULL,
            'user'  => 'guest',
            'admin' => 'user',
        ],
        // resources and rights are assigned in each module.config.php file
        /*
        'resources' => [],
        'rights' => [
            'guest' => [],
            'user' => [],
            'admin' => [],
        ],
        */
        'assertions' => [
            'date-time-assert-config' => [
                'start' => ['hour' => 9, 'minute' => 0, 'second' => 0],
                'stop'  => ['hour' => 22, 'minute' => 0, 'second' => 0],
            ],
        ],
    ],
];
