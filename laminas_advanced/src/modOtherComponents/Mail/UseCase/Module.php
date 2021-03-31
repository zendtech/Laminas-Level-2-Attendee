<?php
/**
 * Module
 */
namespace src\modOtherComponents\Mail\UseCase;
use Events\Listener\Aggregate;
use Laminas\Mail\Transport\{File, FileOptions, Sendmail};
class Module
{
    // ...
    public function getServiceConfig() {
        return [ 'factories' => [
            'email-notification-transport-file' => function ($sm) {
                return new File( new FileOptions(
                    $sm->get('email-notification-config')['transport-options']['file']));
            },
            'email-notification-transport-sendmail' => function ($sm) {
                return new SendMail();
            },
            'email-notification-listener' => function ($sm) {
                return new Aggregate($sm);
            },
        ]];
    }
}
