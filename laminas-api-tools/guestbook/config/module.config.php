<?php
return [
    'service_manager' => [
        'factories' => [
            \guestbook\V1\Rest\GuestbookApi\GuestbookApiResource::class => \guestbook\V1\Rest\GuestbookApi\GuestbookApiResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'guestbook.rest.guestbook-api' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/guestbook-api[/:guestbook_api_id]',
                    'defaults' => [
                        'controller' => 'guestbook\\V1\\Rest\\GuestbookApi\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'guestbook.rest.guestbook-api',
        ],
    ],
    'api-tools-rest' => [
        'guestbook\\V1\\Rest\\GuestbookApi\\Controller' => [
            'listener' => \guestbook\V1\Rest\GuestbookApi\GuestbookApiResource::class,
            'route_name' => 'guestbook.rest.guestbook-api',
            'route_identifier_name' => 'guestbook_api_id',
            'collection_name' => 'guestbook_api',
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
            'entity_class' => \guestbook\V1\Rest\GuestbookApi\GuestbookApiEntity::class,
            'collection_class' => \guestbook\V1\Rest\GuestbookApi\GuestbookApiCollection::class,
            'service_name' => 'GuestbookApi',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'guestbook\\V1\\Rest\\GuestbookApi\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'guestbook\\V1\\Rest\\GuestbookApi\\Controller' => [
                0 => 'application/vnd.guestbook.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'guestbook\\V1\\Rest\\GuestbookApi\\Controller' => [
                0 => 'application/vnd.guestbook.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'api-tools-hal' => [
        'metadata_map' => [
            \guestbook\V1\Rest\GuestbookApi\GuestbookApiEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'guestbook.rest.guestbook-api',
                'route_identifier_name' => 'guestbook_api_id',
                'hydrator' => \Laminas\Hydrator\ObjectPropertyHydrator::class,
            ],
            \guestbook\V1\Rest\GuestbookApi\GuestbookApiCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'guestbook.rest.guestbook-api',
                'route_identifier_name' => 'guestbook_api_id',
                'is_collection' => true,
            ],
        ],
    ],
    'api-tools-content-validation' => [
        'guestbook\\V1\\Rest\\GuestbookApi\\Controller' => [
            'input_filter' => 'guestbook\\V1\\Rest\\GuestbookApi\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'guestbook\\V1\\Rest\\GuestbookApi\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'max' => '255',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StripTags::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'name',
                'description' => 'Name of signee',
                'field_type' => 'string',
                'error_message' => 'Please enter your name',
            ],
            1 => [
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
                        'name' => \Laminas\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'avatar',
                'description' => 'URL to signee avatar',
                'field_type' => 'string',
                'allow_empty' => true,
                'continue_if_empty' => true,
            ],
            2 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\EmailAddress::class,
                        'options' => [
                            'useDomainCheck' => true,
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StripTags::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'email',
                'description' => 'Email address of signee',
                'field_type' => 'string',
                'error_message' => 'Please enter your email address',
            ],
            3 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StripTags::class,
                        'options' => [],
                    ],
                ],
                'name' => 'message',
                'description' => 'Guestbook message',
                'field_type' => 'string',
                'error_message' => 'Please enter a message',
            ],
        ],
    ],
    'api-tools-mvc-auth' => [
        'authorization' => [
            'guestbook\\V1\\Rest\\GuestbookApi\\Controller' => [
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
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
        ],
    ],
];
