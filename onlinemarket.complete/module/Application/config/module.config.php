<?php
namespace Application;
use Application\Model\AbstractTableGateway;
use Application\Model\Factory\AbstractTableGatewayFactory;
use Market\Helper\LeftLinks;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\View\Helper as ViewHelper;
use Laminas\Form\View\Helper as FormHelper;
use Laminas\ServiceManager\Factory\InvokableFactory;
//*** NAVIGATION LAB: activate the NavigationAbstractServiceFactory
use Laminas\Navigation\Service\NavigationAbstractServiceFactory;
use Application\Controller\IndexController;
use Application\Event\AppEventAggregate;
return [
    'router' => [
        'routes' => [
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'exception' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/application/exception',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action' => 'exception',
                    ]
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            IndexController::class => InvokableFactory::class,
        ],
    ],
    'service_manager' => [
        //*** NAVIGATION LAB: activate the default navigation factory
        'abstract_factories' => [
            NavigationAbstractServiceFactory::class
        ],
        'factories' => [
            AppEventAggregate::class => InvokableFactory::class,
            AbstractTableGateway::class => AbstractTableGatewayFactory::class
        ],
    ],
    'listeners' => [
        AppEventAggregate::class
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'view_helpers' => [
        'factories' => [
            LeftLinks::class => InvokableFactory::class,
        ],
        'aliases' => [
            'leftLinks' => LeftLinks::class,
        ],
    ],
    //*** ACL LAB
    'access-control-Config' => [
        'resources' => [
            //*** define a resource 'application-index' which points to 'Application\Controller\IndexController'
            'application-index' => IndexController::class,
        ],
        'rights' => [
            'guest' => [
                //*** for the 'doctrine-index' resource, guests should be allowed any action
                'application-index' => ['allow' => NULL],
            ],
        ],
    ],
];
