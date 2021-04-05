<?php
namespace Registration;
use Laminas\Router\Http\Segment;
use Registration\Controller\{
    Factory\RegistrationControllerFactory,
    RegistrationController
};
use Registration\Form\{
    Factory\RegistrationFilterFactory,
    Factory\RegistrationFormFactory,
    RegistrationFilter,
    RegistrationForm
};

return [
    'navigation' => [
        'default' => [
            'registration' => ['label' => '- Join Us -', 'route' => 'registration', 'tag' => __NAMESPACE__, 'resource' => 'menu-registration'],
        ]
    ],
    'router' => [
        'routes' => [
            'registration' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/registration[/]',
                    'defaults' => [
                        'controller' => RegistrationController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        //*** FORMS LAB: define factories for form and filter classes
        'factories' => [
            RegistrationForm::class => RegistrationFormFactory::class,
            RegistrationFilter::class => RegistrationFilterFactory::class,
        ],
        //*** FORMS LAB: define configuration services for roles, providers and locales
        'services' => [
            'registration-form-roles' => ['guest','user','admin'],
            'registration-form-locales' => ['de','en','es','fr'],
            'registration-form-providers' => ['default','google','facebook','twitter'],
        ],
    ],
    'controllers' => [
        'factories' => [
            RegistrationController::class => RegistrationControllerFactory::class,
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
            //*** define these resources:
            'registration' => RegistrationController::class,
            //*** NAVIGATION LAB: add these resources
            'menu-registration' => 'menu-registration',
        ],
        'rights' => [
            'guest' => [
                //*** for the "login" resource, allow guests to use the "login" and "register" actions
                'registration' => ['allow' => ['index']],
                //*** NAVIGATION LAB: allow guests to see the "login" menu option
                'menu-registration' => ['allow' => NULL],
            ],
        ],
    ],
];
