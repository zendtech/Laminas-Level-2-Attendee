<?php

namespace Events;
use Laminas\Router\Http\ {Literal, Segment};
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Mvc\Controller\LazyControllerAbstractFactory;
use Laminas\ServiceManager\AbstractFactory\{ConfigAbstractFactory, ReflectionBasedAbstractFactory};
use Events\Controller\{
    IndexController,
};
use Events\Doctrine\{
    Controller\SignupController,
};
use Events\TableModule\{
    Controller\Factory\AdminControllerFactory,
    Controller\Factory\SignupControllerFactory,
    Controller\AdminController,
    Controller\IndexController as TableModuleIndexController,
    Model\AttendeeTable,
    Model\EventModel,
    Model\RegistrationTable
};

return [
    'navigation' => [
        'default' => [
            'events' => ['label' => 'Events', 'route' => 'events', 'resource' => 'menu-events']
        ]
    ],
    'router' => [
        //'router_class' => TranslatorAwareTreeRouteStack::class,
        'routes' => [
            'events' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/events',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => TRUE,
                'child_routes' => [
                    'table-module' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/table-module',
                            'defaults' => [
                                'controller' => IndexController::class,
                                'action' => 'index',
                            ],
                        ],
                        'may_terminate' => TRUE,
                        'child_routes' => [
                            'admin' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/admin[/][:event]',
                                    'defaults' => [
                                        'controller' => AdminController::class,
                                        'action' => 'index',
                                    ],
                                    'constraints' => [
                                        'event' => '[0-9]+',
                                    ],
                                ],
                            ],
                            'signup' => [
                                'type' => Segment::class,
                                'options' => [
                                    // example of translatable route:
                                    //'route'    => '/{signup}[/][:event]',
                                    'route' => '/signup[/][:event]',
                                    'defaults' => [
                                        'controller' => SignupController::class,
                                        'action' => 'index',
                                    ],
                                    'constraints' => [
                                        'event' => '[0-9]+',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            ReflectionBasedAbstractFactory::class,
        ],
        'factories' => [
            EventModel::class => ReflectionBasedAbstractFactory::class,
            AttendeeTable::class => ReflectionBasedAbstractFactory::class,
            RegistrationTable::class => ReflectionBasedAbstractFactory::class,
        ],
        'services' => [
            'events-menu-config' => [
                'events-table-module' => [
                    'label' => 'Table Module',
                    'route' => 'events',
                    'resource' => 'menu-events-tm',
                    'pages' => [
                        ['label' => 'Sign Up Form',
                            'route' => 'events/table-module/signup', 'resource' => 'menu-events-tm-signup',
                            'pages' => [
                                ['label' => 'Event A', 'route' => 'events/table-module/signup', 'params' => ['event' => 1]],
                                ['label' => 'Event B', 'route' => 'events/table-module/signup', 'params' => ['event' => 2]],
                            ],
                        ],
                        ['label' => 'Admin Area',
                            'route' => 'events/table-module/admin', 'resource' => 'menu-events-tm-admin',
                            // do not need ACL "resource" for pages below this
                            'pages' => [
                                ['label' => 'Event A', 'route' => 'events/table-module/admin', 'params' => ['event' => 1]],
                                ['label' => 'Event B', 'route' => 'events/table-module/admin', 'params' => ['event' => 2]],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'abstract_factories' => [
            LazyControllerAbstractFactory::class,
            ConfigAbstractFactory::class,
        ],
        'factories' => [
            IndexController::class => LazyControllerAbstractFactory::class,
            IndexController::class => InvokableFactory::class,
            AdminController::class => AdminControllerFactory::class,
            SignupController::class => SignupControllerFactory::class,
        ],
    ],
    // this is not used in this course, but illustrates the use of ConfigAbstractFactory
    /*
    ConfigAbstractFactory::class => [
            Doctrine\Controller\SignupController::class => [
                Doctrine\Repository\EventRepo::class,
                Doctrine\Repository\AttendeeRepo::class,
                Doctrine\Repository\RegistrationRepo::class,
            ],
            Doctrine\Controller\AdminController::class  => [
                Doctrine\Repository\EventRepo::class,
                Doctrine\Repository\AttendeeRepo::class,
                Doctrine\Repository\RegistrationRepo::class,
            ],
    ],
     */
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
    ],
    'access-control-config' => [
        'resources' => [
            'events-index' => IndexController::class,
            'events-tb-index' => TableModuleIndexController::class,
            'events-tb-admin' => AdminController::class,
            'events-tb-sign' => SignupController::class,
            'menu-events' => 'menu-events',
            'menu-events-tm' => 'menu-events-tm',
            'menu-events-tm-signup' => 'menu-events-tm-signup',
            'menu-events-tm-admin' => 'menu-events-tm-admin',

        ],
        'rights' => [
            'guest' => [
                'events-index' => ['allow' => NULL],
                'events-tb-index' => ['allow' => NULL],
                'events-tb-sign' => ['allow' => NULL],
                'menu-events' => ['allow' => NULL],
                'menu-events-tm' => ['allow' => NULL],
                'menu-events-tm-signup' => ['allow' => NULL],
            ],
            'admin' => [
                'events-tb-admin' => ['allow' => NULL, 'assert' => 'access-control-datetime-assert'],
                'menu-events-tm-admin' => ['allow' => NULL, 'assert' => 'access-control-datetime-assert'],
            ],
        ],
    ],
];
