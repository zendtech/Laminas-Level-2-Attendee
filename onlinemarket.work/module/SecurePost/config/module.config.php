<?php
namespace SecurePost;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'view_manager' => [
        'template_map' => [
            'registration/reg/index' => __DIR__ . '/../view/registration/reg/index.phtml',
        ],
    ],
];
