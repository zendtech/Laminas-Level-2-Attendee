<?php
namespace PrivateMessages;
use Laminas\Router\Http\Segment;
use PrivateMessages\Controller\{
    Factory\IndexControllerFactory,
    IndexController
};
use PrivateMessages\Form\{Factory\SendFormFactory, SendForm, SendFormInputFilter};
use PrivateMessages\Model\{Factory\MessagesModelFactory, MessageEntity, MessagesModel};
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'navigation' => [
        'default' => [
            'messages' => ['label' => '- Message -', 'route' => 'messages', 'resource' => 'menu-private-messages']
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
        ],
    ],
    'service_manager' => [
        'factories' => [
            SendForm::class => SendFormFactory::class,
            SendFormInputFilter::class => InvokableFactory::class,
            MessagesModel::class => MessagesModelFactory::class,
            MessageEntity::class => InvokableFactory::class
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
    //*** ACL LAB
    'access-control-Config' => [
        'resources' => [
            //*** ACL LAB: define a resource "messages" which points to 'PrivateMessages\Controller\IndexController',
            'private-messages-index' => IndexController::class,
            //*** NAVIGATION LAB: define a private message menu item as a resource
            'menu-private-messages' => 'menu-private-messages',
        ],
        'rights' => [
            'user' => [
                //*** ACL LAB: for the "messages" resource users are allowed all actions
                'private-messages-index' => ['allow' => NULL],
                //*** NAVIGATION LAB: users are allowed to see any messages menu resource item
                'menu-private-messages' => ['allow' => NULL],
            ],
        ],
    ],
];
