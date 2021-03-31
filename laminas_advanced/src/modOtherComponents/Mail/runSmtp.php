<?php
/**
 * Code Runner
 */
require __DIR__ . '/../../../vendor/autoload.php';
use Laminas\Mail\{Message, Transport\Smtp, Transport\SmtpOptions};
$message = new Message();
$message->addTo('daryl@datashuttle.net')
    ->addFrom('doug@unlikelysource.com')
    ->setSubject('Greetings and Salutations!')
    ->setBody("Sorry, I'm going to be late today!");

$transport = new Smtp();
$options   = new SmtpOptions([
    'name'              => 'localhost.localdomain',
    'host'              => '127.0.0.1',
    'connection_class'  => 'login',
    'connection_config' => [
        'username' => 'user',
        'password' => 'pass',
    ],
]);

$transport->setOptions($options);
$transport->send($message);
