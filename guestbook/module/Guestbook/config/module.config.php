<?php
namespace Guestbook;
use Zend\Router\Http\Segment;
use Guestbook\Form\{
    Factory\GuestbookFormFactory,
    Factory\GuestbookFormFilterFactory,
    GuestbookForm,
    GuestbookFormFilter};
use Guestbook\Controller\{
    Factory\IndexControllerFactory,
    IndexController,
};
use Guestbook\Mapper\{
    Factory\GuestbookMapperFactory,
    GuestbookMapper,
};
use Guestbook\Listener\{
    Factory\CacheListenerAggregateFactory,
    CacheListenerAggregate,
};

return [
    'navigation' => [
        'default' => [
            'home' => ['label' => 'Home', 'route' => 'home', 'resource' => 'menu-guestbook-home'],
            'sign' => ['label' => 'Sign', 'uri' => '/guestbook/sign', 'resource' => 'menu-guestbook-sign']
        ]
    ],
    'router' => [
        'routes' => [
            'guestbook' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/guestbook[/:action]',
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
            'guestbook-audit-filename' => __DIR__ . '/../../../data/logs/guestbook_audit.log',
            'guestbook-avatar-config' => [
                'img_size'   => ['maxWidth' => 100, 'maxHeight' => 100],
                'file_size'  => ['max' => 204800],
                'rename'     => ['target' => realpath(__DIR__ . '/../../../data/uploads'), 'randomize' => TRUE],
            ],
        ],
        'aliases' => [
            // config is in /config/autoload/db.local.php
            'guestbook-db-config' => 'local-db-Config',
        ],
        'factories' => [
            GuestbookForm::class => GuestbookFormFactory::class,
            GuestbookFormFilter::class => GuestbookFormFilterFactory::class,
            GuestbookMapper::class => GuestbookMapperFactory::class,
            CacheListenerAggregate::class =>CacheListenerAggregateFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            IndexController::class => IndexControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
        'strategies' => ['ViewJsonStrategy'],
    ],
    'listeners' => [
        CacheListenerAggregate::class,
    ],
    // adds to the module AccessControl configuration
    'access-control-config' => [
        'resources' => [
            'guestbook'           => 'Guestbook\Controller\IndexController',
            'menu-guestbook-home' => 'menu-guestbook-home',
            'menu-guestbook-sign' => 'menu-guestbook-sign',
        ],
        'rights' => [
            'guest' => [
                'guestbook' => ['allow' => NULL], // NULL == any rights
                'menu-guestbook-home' => ['allow' => NULL],
                'menu-guestbook-sign' => ['allow' => NULL],
            ],
        ],
    ],
];
