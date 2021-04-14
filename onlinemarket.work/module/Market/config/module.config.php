<?php
namespace Market;
use Market\Controller\{
    Factory\IndexControllerFactory,
    IndexController,
    Factory\ViewControllerFactory,
    ViewController,
    Factory\PostControllerFactory,
    PostController
};
use Market\Form\{
    Factory\PostFormFactory,
    PostForm,
    Factory\PostFilterFactory,
    PostFilter
};
use Market\Helper\LeftLinks;
use Laminas\Router\Http\{Literal, Segment};
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'market' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/market',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'post' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/post[/]',
                            'defaults' => [
                                'controller' => PostController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'lookup' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/lookup[/]',
                                    'defaults' => [
                                        'action'     => 'lookup',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'view' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/view',
                            'defaults' => [
                                'controller' => ViewController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'slash' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/',
                                ],
                            ],
                            'category' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/category[/:category]',
                                    'constraints' => [
                                        'category' => '[A-Za-z0-9]*',
                                    ],
                                    'defaults' => [
                                        'action'     => 'index',
                                    ],
                                ],
                            ],
                            'item' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/item[/:itemId]',
                                    'constraints' => [
                                        'itemId' => '[0-9]*',
                                    ],
                                    'defaults' => [
                                        'action'     => 'item',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'services' => [
            'market-categories' => [
                'barter',
                'beauty',
                'clothing',
                'computer',
                'entertainment',
                'free',
                'garden',
                'general',
                'health',
                'household',
                'phones',
                'property',
                'sporting',
                'tools',
                'transportation',
                'wanted',
            ],
            'market-expire-days' => [
                0  => 'Never',
                1  => 'Tomorrow',
                7  => 'Week',
                30 => 'Month',
            ],
            'market-captcha-options' => [
                'expiration' => 300,
                'fontSize'  => 24,
                'height'    => 50,
                'width'     => 200,
                // These two paths are relative to the configuration directory
                'font'      => __DIR__ . '/../../../public/fonts/FreeSansBold.ttf',
                'imgDir'    => __DIR__ . '/../../../public/captcha',
                // This URL is relative to the host.
                'imgUrl'    => '/onlinemarket.work/captcha',
            ],
            //*** FILE UPLOAD LAB: define Config for file upload validators and filter
            'market-upload-Config' => [
                'img_size'   => [],
                'file_size'  => [],
                'rename'     => [],
                'img_url'    => '/images',
            ],
        ],
        'factories' => [
            PostForm::class => PostFormFactory::class,
            PostFilter::class => PostFilterFactory::class,
            //*** CACHE LAB: add missing factory for Market\Listener\CacheAggregate
        ],
    ],
    //*** CACHE LAB: add entries to represent listeners defined as aggregates
    //'listeners' => [ Listener\CacheAggregate::class ],
    'controllers' => [
        'factories' => [
            IndexController::class => IndexControllerFactory::class,
            ViewController::class => ViewControllerFactory::class,
            PostController::class => PostControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
    ],
    'view_helpers' => [
        'factories' => [
            LeftLinks::class => InvokableFactory::class,
        ],
        'aliases' => [
            'leftLinks' => LeftLinks::class,
        ],
    ],
    //*** NAVIGATION LAB: define default navigation
    'navigation' => [
        'default' => [
            'market-home' => ['label' => '- Home -', 'order' => -100, 'route' => 'market', 'resource' => 'menu-market-index'],
            'market-post' => ['label' => '- Post -', 'route' => 'market/post', 'resource' => 'menu-market-post'],
        ],
    ],
    //*** ACL LAB
    'access-control-Config' => [
        'resources' => [
            'market-index' => IndexController::class,
            //*** ACL LAB: define a resource "market-view" which points to 'Market\Controller\ViewController',
            'market-view' => ViewController::class,
            //*** ACL LAB: define a resource "market-post" which points to 'Market\Controller\PostController',
            'market-post' => TestController::class,
            //*** NAVIGATION LAB: define a market menu item as resources
            'menu-market-index' => 'menu-market-index',
            'menu-market-view'  => 'menu-market-view',
            'menu-market-post'  => 'menu-market-post',
        ],
        'rights' => [
            'guest' => [
                'market-index' => ['allow' => NULL],
                //*** ACL LAB: for the "market-view" resource guests are allowed all actions
                //*** NAVIGATION LAB: guests are allowed to see market index menu item as (e.g. 'Home')
            ],
            'user' => [
                //*** ACL LAB: for the "market-post" resource users are allowed all actions
                //*** NAVIGATION LAB: users are allowed to see the market post menu item
            ],
        ],
    ],
];

