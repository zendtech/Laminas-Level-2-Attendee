<?php
namespace AuthOauth;
use AuthOauth\Controller\{
    Factory\IndexControllerFactory,
    IndexController,
};
use AuthOauth\Listener\Factory\{
    ListenerAggregateFactory,
};
use AuthOauth\{
    Generic\User,
    Generic\Hydrator,
    Listener\OauthListenerAggregate,
};

return [
    'router' => [
        'routes' => [
            'auth-oauth' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/oauth[/:action]',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            IndexController::class => IndexControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
    ],
    'service_manager' => [
        'aliases' => [
            'auth-oauth-service' => 'login-auth-service',
        ],
        'services' => [
            'auth-oauth-callback' => '/oauth/callback',
            'auth-oauth-storage-filename' => __DIR__ . '/../../../data/auth/auth-oauth.txt',
            // override this in /config/autoload/auth-oauth.local.php
            'auth-oauth-config' => [
                'google' => [
                    'clientId'     => 'client.id.from.apps.googleusercontent.com',
                    'clientSecret' => 'client.secret.apps.googleusercontent.com',
                    'redirectUri'  => 'http://localhost/oauth/callback',
                ],
            ],
        ],
        'factories' => [
            User::class => InvokableClassFactory::class,
            Hydrator::class => InvokableClassFactory::class,
            OauthListenerAggregate::class => ListenerAggregateFactory::class,
        ],
    ],
    'listeners' => [
        OauthListenerAggregate::class,
    ],
    'access-control-config' => [
        'resources' => [
            'auth-oauth-index'=> IndexController::class,
        ],
        'rights' => [
            'guest' => [
                'auth-oauth-index' => ['allow' => NULL],
            ],
        ],
    ],
];
