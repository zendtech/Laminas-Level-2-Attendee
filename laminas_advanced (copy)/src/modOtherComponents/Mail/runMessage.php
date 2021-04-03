<?php
/**
 * Code Runner
 */
require __DIR__ . '/../../../vendor/autoload.php';
use Zend\Mail\Message;
$message = new Message();

// NOTE: supports optional "human readable" names
$message->addFrom('sender@abc.com', 'I. M. Sender')
    ->addTo('foobar@example.com', 'I. M. Human')
    ->setSubject('Sending an email from Zend\Mail!')
    ->setBody('This is the message body.');

// Add additional recipients as a "Cc" or "Bcc":
$message->addCc('C.C.Recipient@zend.com')
    ->addBcc('B.C.C.Recipient@zend.com');

// Add an alternate reply address:
$message->addReplyTo('info@abc.com', 'Customer Service');
