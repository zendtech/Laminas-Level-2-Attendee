<?php
/**
 * Code Runner
 */
require __DIR__ . '/../../../vendor/autoload.php';
use Laminas\Mail\{Message, Transport\Sendmail};

$message = new Message();
$message->addTo('daryl@datashuttle.net')
    ->addFrom('doug@unlikelysource.com')
    ->setSubject('Greetings and Salutations!')
    ->setBody("Sorry, I'm going to be late today!");

$transport = new Sendmail();
$transport->send($message);
