<?php
declare(strict_types=1);
namespace Notification;
use Laminas\Mail\Transport\{File, FileOptions, Sendmail};
class Module
{
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'notification-transport-file' => function ($container) {
                    return new File( new FileOptions(
                        $container->get('notification-config')['transport-options']['file']));
                },
                'notification-transport-sendmail' => function ($container) {
                    return new SendMail();
                },
                Listener\Aggregate::class => function ($container) {
                    $listener = new Listener\Aggregate();
                    $listener->setContainer($container);
                    return $listener;
                },
            ]
        ];
    }
}
