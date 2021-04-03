<?php
use src\modCrossCuttingConcerns\ListenerAggragates\AppEventAggregate;
use src\modSecurity\Acl\UseCase\Module;
use src\modServices\Delegators\{Foo, FooDelegatorFactory};
use Laminas\ServiceManager\Factory\InvokableFactory;
return [
    'db' => [
        'driver' => 'PDO',
        'dsn'    => 'mysql:host=localhost;dbname=zfcourse',
        'username' => 'laminas',
        'password' => 'password',
    ],
    'auth_adapters' => [
        'http' => [
            'accept_schemes' => 'basic digest',
            'realm'          => 'My Web Site',
            'digest_domains' => '/members_only/my_account',
            'nonce_timeout'  => 3600,
        ],
        'ldap' => [
            'host'                   => 's0.foo.net',
            'accountDomainName'      => 'foo.net',
            'accountDomainNameShort' => 'FOO',
            'accountCanonicalForm'   => 3,
            'username'               => 'CN=user1,DC=foo,DC=net',
            'password'               => 'pass1',
            'baseDn'                 => 'OU=Sales,DC=foo,DC=net',
            'bindRequiresDn'         => true,
        ]
    ],
    'services' => [
        'service' => [
            'fooService' => 'a cool foo'
        ],
        'initializers' => [
            \Module\Mapper\MyMapperInitializer::class,
        ],
        'factories' => [
            Foo::class => InvokableFactory::class,
            AppEventAggregate::class =>
                InvokableFactory::class
        ],
        'listeners' => [
            AppEventAggregate::class,
            'email-notification-listener',
        ],
        'delegators' => [
            Foo::class => [
                FooDelegatorFactory::class
            ],
        ],
        'email-notification-config' => [
            'transport-options' => [
                'file' => ['path' => __DIR__ . '/../../../data/mail'],
            ],
            'template_map' => [
                'email-notification/template' =>
                    __DIR__ . '/../modOtherComponents/mail/UseCase/mail.phtml',
            ],
            'email-options' => [
                'subject'      => 'Event Registration Confirmation',
                'from'         => 'webmaster@zend.com',
                'transport'    => 'file', // must be smtp | sendmail | file
            ],
        ],
        'access-control-config' => [
            'roles' => [
                Module::DEFAULT_ROLE => NULL,
                'user' => Module::DEFAULT_ROLE,
                'admin' => 'user',
            ],
            'resources' => [
                'guestbook' => 'Guestbook\Controller\GuestbookController',
                'login'     => 'Login\Controller\IndexController',
                'messages'  => 'PrivateMessages\Controller\IndexController',
                'app-index' => 'Application\Controller\IndexController'
            ],
            'rights' => [
                Module::DEFAULT_ROLE => [
                    'login'            => ['allow' => NULL],
                    'guestbook'        => ['allow' => NULL],
                ],
                'user' => [
                    'messages'  => ['allow' => NULL],
                ],
                'admin' => [
                    'events-tb-admin'  =>
                        ['allow' => NULL, 'assert' => 'datetime-assert'],
                    'events-doc-admin' =>
                        ['allow' => NULL, 'assert' => 'datetime-assert'],
                ],
            ]
        ]
    ],
    'router' => [
        'routes' => [
            'post-submit' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/post/submit',
                    'defaults' => [
                        'controller' => Market\Controller\TestController::class,
                        'action' => 'submit',
                        'needs-user' => TRUE,
                    ],
                ],
            ]
        ]
    ],
    'navigation' => [
        [
            'label' => 'Home',
            'id' => 'home',
            'uri' => '/',
            'order' => 1,
        ],
        [
            'label' => 'About',
            'uri' => '/about',
            'order' => 2,
            'controller' => 'AboutController',
            'pages' => [
                [
                    'label' => 'Us',
                    'action' => 'us',
                    'controller' => 'history',
                    'class' => 'history',
                    'title' => 'Our history',
                    'active' => true,
                ],
            ]
        ],
    ],
    'view_manager' => [
        'strategies' => ['ViewJsonStrategy']
    ]
];
