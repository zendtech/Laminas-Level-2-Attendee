<?php
/**
 * Code Runner
 */
require __DIR__ . '/../../../vendor/autoload.php';
use Laminas\Mail\{Message, Transport\File, Transport\FileOptions};
$message = new Message();
$message->addTo('daryl@datashuttle.net')
    ->addFrom('doug@unlikelysource.com')
    ->setSubject('Greetings and Salutations!')
    ->setBody("Sorry, I'm going to be late today!");

$transport = new File();
$options   = new FileOptions(array(
    'path'      => '../../data/mail/',
    'callback'  => function (File $transport) {
        return 'Message_' . microtime(true) . '_' . mt_rand() . '.txt';
    },
));

$transport->setOptions($options);
$transport->send($message);
