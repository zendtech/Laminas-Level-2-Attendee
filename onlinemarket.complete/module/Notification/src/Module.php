<?php
namespace Notification;

use Zend\Mvc\MvcEvent;
//*** EMAIL LAB: add the appropriate "use" statements
use Zend\Mail\Transport\ {SendMail, Smtp, File};
use Zend\Mail\Transport\ {SmtpOptions, FileOptions};
use Interop\Container\ContainerInterface;
use Notification\Listener\AggregateListener;

class Module
{
    //*** EMAIL LAB: return the appropriate configuration which registers Notification\Listener\AggregateListener as a listener
    public function getConfig()
    {
        return [
            'listeners' => [ AggregateListener::class ]
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
                Listener\AggregateListener::class => function (ContainerInterface $container, $requestedName, ?array $options = NULL)
                {
                    $aggregate = new $requestedName();
                    $aggregate->setServiceContainer($container);
                    return $aggregate;
                },
                //*** EMAIL LAB: define each of these transports
                'notification-transport-smtp' =>
                    function (ContainerInterface $container, $requestedName, ?array $options = NULL) {
                        $config = $container->get('notification-Config');
                        return new Smtp(new SmtpOptions($config['transport']['options']));
                    },
                'notification-transport-file' =>
                    function (ContainerInterface $container, $requestedName, ?array $options = NULL) {
                        $config = $container->get('notification-Config');
                        return new File(new FileOptions($config['transport']['options']));
                    },
                'notification-transport-sendmail' =>
                    function (ContainerInterface $container, $requestedName, ?array $options = NULL) {
                        return new SendMail();
                    },
            ],
        ];
    }
}
