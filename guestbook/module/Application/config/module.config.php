<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;
use Laminas\Router\Http\Literal;
use Laminas\Mvc\Router\Console\Simple;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Navigation\Service\NavigationAbstractServiceFactory;
use Laminas\Mvc\Controller\Plugin\FlashMessenger;
use Application\Controller\{
    Factory\IndexControllerFactory,
    IndexController,
};
use Application\Event\{
    Factory\ErrorLogFactory,
    Factory\ErrorLogWithFilterFactory,
    Listener\ErrorLog,
    Listener\ErrorLogWithFilter,
    Filter\MaskCcnum,
};

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'services' => [
            'application-log-dir'      => realpath(__DIR__ . '/../../../data/logs'),
            'application-log-filename' => 'message.log',
        ],
        'factories' => [
            ErrorLog::class => ErrorLogFactory::class,
            MaskCcnum::class => InvokableFactory::class,
            ErrorLogWithFilter::class => ErrorLogWithFilterFactory::class,
        ],
        'abstract_factories' => [
            NavigationAbstractServiceFactory::class
        ],
    ],
    'controllers' => [
        'factories' => [
            IndexController::class => IndexControllerFactory::class,
        ],
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
    'access-control-config' => [
        'resources' => [
            'app-index' => IndexController::class,
        ],
        'rights' => [
            'guest' => [
                'app-index' => ['allow' => NULL],
            ],
        ],
    ],
];
