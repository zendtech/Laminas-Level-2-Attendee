<?php
declare(strict_types=1);
namespace Notification;
use Laminas\ServiceManager\Factory\InvokableFactory;
return [
    'service_manager' => [
        'services' => [
            'notification-config' => [
                'transport-options' => [
                    'file' => [
                        'path' => __DIR__ . '/../../../data/mail'
                    ]
                ],
                'send-options' => [
                    'subject'      => 'Event Registration Confirmation',
                    'from'         => 'webmaster@zend.com',
                    'transport'    => 'file', // must be smtp | sendmail | file
                ],
                'template_map' => [
                    'notification/template' => __DIR__ . '/../view/notification/mail.phtml',
                ],
            ],
        ],
    ],
    'listeners' => [Listener\Aggregrate::class],
];
