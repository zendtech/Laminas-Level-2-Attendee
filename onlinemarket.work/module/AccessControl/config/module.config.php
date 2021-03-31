<?php
namespace AccessControl;
use AccessControl\Listener\AclListenerAggregate;
use AccessControl\Assertion\ {
    DateTimeAssert,
    Factory\DateTimeAssertFactory
};
use AccessControl\Acl\ {
    Factory\MarketAclFactory,
    MarketAcl
};

return [
    'listeners' => [
        AclListenerAggregate::class,
    ],
    'service_manager' => [
        'factories' => [
            DateTimeAssert::class => DateTimeAssertFactory::class,
            MarketAcl::class => MarketAclFactory::class,
        ],
    ],
    'access-control-Config' => [
        //*** define core roles here:
        'roles' => [
            'guest' => NULL,
            //***   user inherits from guest
            'user' => 'guest',
            //***   admin inherits from user
            'admin' => 'user',
        ],
        //*** resources and rights are assigned in each module.Config.php file using this format
        /*
        'resources' => [
            'arbitrary-acl-key' => 'Namespace\Controller\WhateverController',
        ],
        'rights' => [
            'guest' => [
                'arbitrary-acl-key' => ['allow' => ['action1','action2',etc.], 'deny' => ['action1','action2',etc]],
            ],
            'user' => [
                'arbitrary-acl-key' => ['allow' => ['action1','action2',etc.], 'deny' => ['action1','action2',etc]],
            ],
            'admin' => [
                'arbitrary-acl-key' => ['allow' => ['action1','action2',etc.], 'deny' => ['action1','action2',etc]],
            ],
        ],
        */
        'assertions' => [
            'date-time-assert-Config' => [
                //*** ACL LAB: experiment with these and make sure it works
                'start' => ['hour' => 6, 'minute' => 0, 'second' => 0],
                'stop'  => ['hour' => 22, 'minute' => 0, 'second' => 0],
            ],
        ],
    ],
];
