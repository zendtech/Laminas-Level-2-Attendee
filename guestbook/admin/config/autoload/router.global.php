<?php

use Mezzio\Router\RouterInterface;
use Mezzio\Router\LaminasRouter;

return [
    'dependencies' => [
        'invokables' => [
            RouterInterface::class => LaminasRouter::class,
        ],
    ],
];
