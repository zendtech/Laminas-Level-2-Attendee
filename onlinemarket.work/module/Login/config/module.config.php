<?php
namespace Login;

use PDO;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Login\Listener\AggregateListener;

return [
    'router' => [
        'routes' => [
            'login' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/login[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'services' => [
            'login-storage-file' => __DIR__ . '/../../../data/auth/storage.txt',
        ],
        'factories' => [
            Form\Login::class => Form\Factory\LoginFormFactory::class,
            Model\UsersModel::class => Model\Factory\UsersModelFactory::class,
            //*** AUTHENTICATION LAB: define aggregate as invokable
        ],
    ],
    //*** AUTHENTICATION LAB: add aggregate as listener
    'listeners' => [
        /* add listener here */
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\Factory\IndexControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    //*** NAVIGATION LAB: define default navigation
    'navigation' => [
        'default' => [
            'login' => ['label' => 'Login', 'route' => 'login', 'resource' => 'menu-login-login'],
            'logout' => ['label' => 'Logout', 'uri' => 'login/logout', 'resource' => 'menu-login-logout'],
        ],
    ],
    //*** ACL LAB
    'access-control-Config' => [
        'resources' => [
            //*** ACL LAB: define the login index controller as a resource "login"
            'login-index' => Controller\IndexController::class,
            //*** NAVIGATION LAB: add these resources for menu options login and logout
            'menu-login-login' => 'menu-login-login',
            'menu-login-logout' => 'menu-login-logout',
        ],
        'rights' => [
            'guest' => [
                //*** ACL LAB: for the "login" resource, allow guests to use the "login" and "register" actions
                'login-index' => ['allow' => ['login']],
                //*** NAVIGATION LAB: allow guests to see the "login" menu option but not "logout"
                'menu-login-login' => ['allow' => NULL],
            ],
            'user' => [
                //*** ACL LAB: for the "login" resource, allow users to use the "logout"
                'login-index' => ['allow' => ['logout']],
                //*** NAVIGATION LAB: allow users to see the "logout" menu option but not "login"
                'menu-login-logout' => ['allow' => NULL],
                'menu-login-login' => ['deny' => NULL],
            ],
        ],
    ],
];
