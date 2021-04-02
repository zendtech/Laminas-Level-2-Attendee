<?php
namespace PrivateMessages;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;
use PrivateMessages\Controller\{
    Factory\IndexControllerFactory,
    IndexController,
    KeypairsController,
};
use PrivateMessages\Form\{
    Factory\SendFormFactory,
    SendForm,
};
use PrivateMessages\Model\{
    Factory\MessagesTableFactory,
    MessagesTable
};
return [
    'navigation' => [
        'default' => [
            'messages' => ['label' => 'Messages', 'route' => 'messages', 'resource' => 'menu-messages']
        ]
    ],
    'router' => [
        'routes' => [
            'messages' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/messages[/:action]',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'keypairs' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/keypairs[/:action]',
                    'defaults' => [
                        'controller' => KeypairsController::class,
                        'action'     => 'diffie',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            SendForm::class => SendFormFactory::class,
            MessagesTable::class => MessagesTableFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            IndexController::class => IndexControllerFactory::class,
            KeypairsController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
    ],
    'access-control-config' => [
        'resources' => [
            'messages'        => IndexController::class,
            'menu-messages'     => 'menu-messages',
        ],
        'rights' => [
            'user' => [
                'messages'          => ['allow' => NULL],
                'menu-messages'     => ['allow' => NULL],
            ],
        ],
    ],
];
