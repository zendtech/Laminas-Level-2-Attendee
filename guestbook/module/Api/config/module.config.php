<?php
return [
    'service_manager' => [
        'factories' => [
            \Api\V1\Rest\ApiService\ApiServiceResource::class => \Api\V1\Rest\ApiService\ApiServiceResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'api.rest.api-service' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api[/:api_service_id]',
                    'defaults' => [
                        'controller' => 'Api\\V1\\Rest\\ApiService\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'api.rest.api-service',
        ],
    ],
    'api-tools-rest' => [
        'Api\\V1\\Rest\\ApiService\\Controller' => [
            'listener' => \Api\V1\Rest\ApiService\ApiServiceResource::class,
            'route_name' => 'api.rest.api-service',
            'route_identifier_name' => 'api_service_id',
            'collection_name' => 'api_service',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
                4 => 'POST',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Api\V1\Rest\ApiService\ApiServiceEntity::class,
            'collection_class' => \Api\V1\Rest\ApiService\ApiServiceCollection::class,
            'service_name' => 'ApiService',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'Api\\V1\\Rest\\ApiService\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Api\\V1\\Rest\\ApiService\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Api\\V1\\Rest\\ApiService\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'api-tools-hal' => [
        'metadata_map' => [
            \Api\V1\Rest\ApiService\ApiServiceEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.api-service',
                'route_identifier_name' => 'api_service_id',
                'hydrator' => \Laminas\Hydrator\ObjectPropertyHydrator::class,
            ],
            \Api\V1\Rest\ApiService\ApiServiceCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.api-service',
                'route_identifier_name' => 'api_service_id',
                'is_collection' => true,
            ],
        ],
    ],
    'api-tools-content-validation' => [
        'Api\\V1\\Rest\\ApiService\\Controller' => [
            'input_filter' => 'Api\\V1\\Rest\\ApiService\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'Api\\V1\\Rest\\ApiService\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Laminas\I18n\Validator\Alpha::class,
                        'options' => [
                            'allowwhitespace' => true,
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'name',
                'description' => 'Name of person signing the Guestbook',
                'error_message' => 'Please enter your name',
                'field_type' => 'string',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\EmailAddress::class,
                        'options' => [],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'email',
                'description' => 'Guest email',
                'field_type' => 'string',
                'error_message' => 'Please enter your email address',
            ],
            2 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\Uri::class,
                        'options' => [
                            'allowRelative' => true,
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'website',
                'description' => 'Guest website (if any)',
                'field_type' => 'string',
            ],
            3 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\Uri::class,
                        'options' => [
                            'allowRelative' => true,
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'avatar',
                'description' => 'URL to avatar (if any)',
                'field_type' => 'string',
            ],
            4 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'dateSigned',
                'description' => 'Defaults to today',
                'field_type' => 'string',
            ],
            5 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StripTags::class,
                        'options' => [
                            'allowTags' => '<p><b><i><ul><li>',
                        ],
                    ],
                ],
                'name' => 'message',
                'description' => 'Signing message',
                'field_type' => 'string',
                'error_message' => 'Please enter a message',
            ],
        ],
    ],
    'api-tools-mvc-auth' => [
        'authorization' => [
            'Api\\V1\\Rest\\ApiService\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
            ],
        ],
    ],
];
