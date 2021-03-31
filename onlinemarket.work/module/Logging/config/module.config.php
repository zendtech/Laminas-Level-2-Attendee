<?php
namespace Logging;

return [
    //*** LOGGER LAB: define appropriate Config for error log filename + make sure your app has the rights to read/write
    'service_manager' => [
        'services' => [
            'logging-error-log-filename' => __DIR__ . '/../../../data/logs/error.log',
        ],
    ],
];
