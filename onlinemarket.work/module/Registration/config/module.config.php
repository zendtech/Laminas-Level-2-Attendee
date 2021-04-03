<?php
namespace Registration;

use Laminas\Router\Http\Segment;

return [
    'navigation' => [
        'default' => [
            'registration' => ['label' => 'Join Us', 'uri' => '/registration', 'tag' => __NAMESPACE__, 'resource' => 'menu-registration'],
        ]
    ],
    'router' => [
        'routes' => [
            'registration' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/registration[/]',
                    'defaults' => [
                        'controller' => Controller\RegController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        //*** FORMS LAB: define factories for form and filter classes
        'factories' => [
        ],
        //*** FORMS LAB: define configuration services for roles
        'services' => [
            'registration-form-roles' => ['guest','user','admin'],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\RegController::class => Controller\Factory\RegControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    //*** ACL LAB
    'access-control-Config' => [
        'resources' => [
            'registration' => Controller\RegController::class,
            'menu-registration' => 'menu-registration',
        ],
        'rights' => [
            'guest' => [
                //*** ACL LAB: for the "login" resource, allow guests to use the "login" and "register" actions
                //*** NAVIGATION LAB: allow guests to see the "login" menu option
            ],
        ],
    ],
];
