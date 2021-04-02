<?php
namespace Notification;

use Laminas\Mvc\MvcEvent;
use Interop\Container\ContainerInterface;
//*** EMAIL LAB: add the appropriate "use" statements

class Module
{
    //*** EMAIL LAB: return the appropriate configuration which registers Notification\Listener\Aggregate as a listener
    public function getConfig()
    {
        return [
            'listeners' => [ Listener\Aggregate::class ]
        ];
    }
    public function getServiceConfig()
    {
        return [
            'services' => [
                // will be overridden in /Config/autoload/global.php
                'notification-Config' => [
                    'from' => 'admin@company.com',
                    // optional:
                    /*
                    'cc' => 'some@email.com',
                    'bcc' => 'some@email.com',
                    */
                    'subject' => 'Say What?',
                    'transport' => [
                        'type' => 'sendmail',      // sendmail | smtp | file
                        'options' => [],
                    ],
                ],
            ],
            'factories' => [
                Listener\Aggregate::class => function (ContainerInterface $container, $requestedName, ?array $options = NULL)
                {
                    $aggregate = new $requestedName();
                    $aggregate->setServiceContainer($container);
                    return $aggregate;
                },
                //*** EMAIL LAB: define the first two transports
                'notification-transport-smtp' => function (ContainerInterface $container, $requestedName, ?array $options = NULL)
                {
                },
                'notification-transport-file' => function (ContainerInterface $container, $requestedName, ?array $options = NULL)
                {
                },
                'notification-transport-sendmail' => function (ContainerInterface $container, $requestedName, ?array $options = NULL)
                {
                    $transport = new SendMail();
                    return $transport;
                },
            ],
        ];
    }
}
