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
    ->setBody('Sorry, I\'m going to be late today!'
             . PHP_EOL . date('l, d M Y H:i:s'));

$transport = new File();
$options   = new FileOptions([
    'path'      => __DIR__ . '/../../data/mail/',
    'callback'  => function (File $transport) {
        return 'Message_' . microtime(true) . '_' . mt_rand() . '.txt';
    },
]);

$transport->setOptions($options);
$transport->send($message);

// have a look at mail files
echo '<pre>';
var_dump($message);
$path = '/home/laminas-advanced/src/data/mail/*';
$url  = 'http://10.20.20.20/laminas-advanced/data/mail/';
$list = glob($path);
foreach ($list as $fn) {
    $short = basename($fn);
    echo '<br /><a href="' . $url . $short . '">' . $short . '</a>';
}
echo '</pre>';
echo '<a href="http://10.20.20.20/laminas-advanced/modOtherComponents/Mail">BACK</a>';
