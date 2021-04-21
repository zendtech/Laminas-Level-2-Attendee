<?php
namespace Events;
use Laminas\Router\Http\{Literal, Segment};
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\ServiceManager\AbstractFactory\ConfigAbstractFactory;
use Events\Controller\{
    AdminController,
    AjaxController,
    IndexController,
    SignUpController
};
use Events\Entity\{EventEntity,
    AttendeeEntity,
    Factory\AttendeeEntityFactory,
    Factory\EventEntityFactory,
    Factory\RegistrationEntityFactory,
    RegistrationEntity};
use Events\Helper\FormMultiTextHelper;
use Events\Model\{
    Factory\TableAbstractFactory,
    EventTableModel,
    AttendeeTableModel,
    RegistrationTableModel,
};

return [
    //*** LISTENER AGGREGATE LAB: attach the listener
    // 'listeners' => [ ??? ],
    'router' => [
        'routes' => [
            'events' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/events',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'index',
                        'module'     => __NAMESPACE__,
                    ],
                ],
                'may_terminate' => TRUE,
                'child_routes' => [
                    'admin' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/admin[/][:eventId]',
                            'defaults' => [
                                'controller' => AdminController::class,
                                'action'     => 'index',
                            ],
                            'constraints' => [
                                'eventId' => '[0-9]+',
                            ],
                        ],
                    ],
                    'ajax' => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/ajax',
                            'defaults' => [
                                'controller' => AjaxController::class,
                                'action'     => 'registration',
                            ],
                        ],
                        'may_terminate' => TRUE,
                        'child_routes' => [
                            'registration' => [
                                'type'    => Segment::class,
                                'options' => [
                                    'route'    => '/registration/:eventId',
                                    'defaults' => [
                                        'controller' => AjaxController::class,
                                        'action'     => 'registration',
                                    ],
                                    'constraints' => [
                                        'eventId' => '[0-9]+',
                                    ],
                                ],
                            ],
                            'attendee' => [
                                'type'    => Segment::class,
                                'options' => [
                                    'route'    => '/attendee/:regId',
                                    'defaults' => [
                                        'controller' => AjaxController::class,
                                        'action'     => 'attendee',
                                    ],
                                    'constraints' => [
                                        'regId' => '[0-9]+',
                                    ],
                                ],
                            ],
                            //*** FORMS AND FIELDSETS LAB: add a route to AJAX request for AttendeeEntity sub-form
                        ],
                    ],
                    'signup' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/signup[/][:eventId]',
                            'defaults' => [
                                'controller' => SignUpController::class,
                                'action'     => 'index',
                            ],
                            'constraints' => [
                                'eventId' => '[0-9]+',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
    ],
    //*** ABSTRACT FACTORIES LAB: comment out the "ConfigAbstractFactory" config:
    ConfigAbstractFactory::class => [
        EventTableModel::class => ['events-db-adapter', EventEntity::class,'events-service-container'],
        AttendeeTableModel::class => ['events-db-adapter', AttendeeEntity::class,'events-service-container'],
        RegistrationTableModel::class => ['events-db-adapter', RegistrationEntity::class,'events-service-container'],
    ],
    'service_manager' => [
        'services' => [
            'events-nav-Config' => [
                ['label' => 'Signup Form', 'class' => 'events-label', 'route' => 'events/signup', 'resource' => 'menu-events-signup-label' ],
                ['label' => 'Signup', 'class' => 'btn btn-block btn-success btn-large', 'route' => 'events/signup', 'resource' => 'menu-events-signup' ],
                ['label' => 'Admin Area', 'class' => 'events-label', 'route' => 'events/admin', 'resource' => 'menu-events-admin-label' ],
                ['label' => 'Admin Area', 'class' => 'btn btn-block btn-success btn-large', 'route' => 'events/admin', 'resource' => 'menu-events-admin' ],
            ],
        ],
        'factories' => [
            // Listener\AggregateListener::class => Listener\Factory\AggregateListenerFactory::class,
            //*** DATABASE ENTITIES LAB: define entity classes as invokables
            EventEntity::class => InvokableFactory::class,
            AttendeeEntity::class => InvokableFactory::class,
            RegistrationEntity::class => InvokableFactory::class,
            //*** ABSTRACT FACTORIES LAB: assign TableAbstractFactory for all three Events model classes
        ],
        //*** ABSTRACT FACTORIES LAB: define an abstract factory TableAbstractFactory builds any *ModelTable classes in the Events module
        'abstract_factories' => [
            ConfigAbstractFactory::class
        ],
        //*** NAVIGATION LAB: define navigation for events as a service container service
    ],
    'view_helpers' => [
        'factories' => [
            FormMultiTextHelper::class => InvokableFactory::class
        ],
        'aliases' => [
            'formMultiText' => FormMultiTextHelper::class,
        ],
    ],
    //*** NAVIGATION LAB: define default navigation
    'navigation' => [
        'default' => [
            ['label' => 'Events', 'route' => 'events', 'resource' => 'menu-events'],
        ],
    ],
    //*** ACL LAB
    'access-control-Config' => [
        'resources' => [
            //*** ACL LAB: define a resource 'events-index' which points to 'Events\Controller\IndexController'
            'events-index' => IndexController::class,
            //*** ACL LAB: define a resource 'events-admin' which points to 'Events\Controller\AdminController',
            'events-admin' => AdminController::class,
            //*** ACL LAB: define a resource 'events-sign' which points to 'Events\Controller\SignupController',
            'events-sign' => SignUpController::class,
            //*** NAVIGATION LAB: assign menu items as resources
            'menu-events' => 'menu-events',
            'menu-events-admin' => 'menu-events-admin',
            'menu-events-signup' => 'menu-events-signup',
            'menu-events-admin-label' => 'menu-events-admin-label',
            'menu-events-signup-label' => 'menu-events-signup-label',
        ],
        'rights' => [
            'guest' => [
                //*** ACL LAB: for the 'events-index' resource, guests should be allowed any action
                'events-index' => ['allow' => NULL],
                //*** ACL LAB: for the 'events-sign' resource, guests should be allowed any action
                'events-sign' => ['allow' => NULL],
                //*** NAVIGATION LAB: guest can see the 'menu-events' and 'menu-events-signup' menu items
                'menu-events'        => ['allow' => NULL],
                'menu-events-signup' => ['allow' => NULL],
                'menu-events-signup-label' => ['allow' => NULL],
            ],
            'admin' => [
                //*** ACL LAB: for the 'events-admin' resource, admin should be allowed any action
                'events-admin' => ['allow' => NULL],
                //*** NAVIGATION LAB: admin can see the 'menu-admin' item
                'menu-events-admin' => ['allow' => NULL],
                'menu-events-admin-label' => ['allow' => NULL],
            ],
        ],
    ],
];
