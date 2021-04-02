<?php
namespace RestApi;
use Laminas\Router\Http\Segment;
use RestApi\Controller\{
    Factory\ApiControllerFactory,
    ApiController
};
use RestApi\Domain\{
    Factory\ApiDomainFactory,
    ApiDomain,
};

return [
    'router' => [
        'routes' => [
            'rest-api' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/api[/][:id]',
                    'defaults' => [
                        'controller' => ApiController::class,
                    ],
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            ApiController::class => ApiControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            ApiDomain::class => ApiDomainFactory::class,
        ],
    ],
    'view_manager' => [
        //*** RESTAPI LAB: enable the ViewJsonStrategy in order to return JsonModels
        'strategies' => [ 'ViewJsonStrategy' ],
    ],
    'access-control-Config' => [
        'resources' => [
            'rest-api-api' => ApiController::class,
        ],
        'rights' => [
            'guest' => [
                'rest-api-api' => ['allow' => NULL],
            ],
        ],
    ],
];
