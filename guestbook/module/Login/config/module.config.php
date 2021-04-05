<?php
namespace Login;
use Laminas\Router\Http\Literal;
use Login\Controller\{
    Factory\IndexControllerFactory,
    IndexController
};
use Login\Form\{Factory\LoginFormFactory,
    Factory\LoginFormInputfilterFactory,
    Factory\QuestionFormFactory,
    Factory\QuestionFormInputFilterFactory,
    Factory\RegisterFormFactory,
    LoginForm,
    LoginFormInputFilter,
    QuestionFormInputFilter,
    RegisterForm,
    QuestionForm};
use Login\Model\{
    Factory\UsersModelFactory,
    UsersModel,
};
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'navigation' => [
        'default' => [
            'login' => ['label' => '- Login -', 'uri' => '/guestbook/login', 'tag' => __NAMESPACE__, 'resource' => 'menu-login-login'],
            'logout' => ['label' => '- Logout -', 'uri' => '/guestbook/logout', 'tag' => __NAMESPACE__, 'resource' => 'menu-login-logout']
        ]
    ],
    'router' => [
        'routes' => [
            'login' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/login',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'logout' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/logout',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'logout',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            LoginForm::class => LoginFormFactory::class,
            LoginFormInputFilter::class => LoginFormInputfilterFactory::class,
            QuestionForm::class => QuestionFormFactory::class,
            QuestionFormInputFilter::class => QuestionFormInputFilterFactory::class,
            RegisterForm::class => RegisterFormFactory::class,
            RegisterFormInputFilter::class => RegisterFormInputFilterFactory::class,
            UsersModel::class => UsersModelFactory::class
        ],
        // override in /config/autoload/login.local.php
        'services' => [
            'login-storage-filename' => __DIR__ . '/../../../data/auth/storage.txt',
            'login-block-cipher-config' => [
                'openssl', ['algo' => 'aes', 'mode' => 'gcm']
            ],
            'login-locale-list' => ['en' => 'English','fr' => 'Français','de' => 'Deutsch','es' => 'Español'],
        ],
    ],
    'controllers' => [
        'factories' => [
            IndexController::class => IndexControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'access-control-config' => [
        'resources' => [
            'login'           => IndexController::class,
            'menu-login-login'  => 'menu-login-login',
            'menu-login-logout' => 'menu-login-logout',
        ],
        'rights' => [
            'guest' => [
                'login'            => ['allow' => ['index','login','register']],
                'menu-login-login' => ['allow' => NULL],
                'menu-login-logout' => ['deny' => NULL],
            ],
            'user' => [
                'login'             => ['allow' => 'logout'],
                'menu-login-login'  => ['deny' => NULL],
                'menu-login-logout' => ['allow' => NULL],
            ],
        ],
    ],
];
