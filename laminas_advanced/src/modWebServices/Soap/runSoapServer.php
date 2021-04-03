<?php
/**
 * Code Runner
 */
use src\modWebServices\Soap\SoapServerClass;
use Laminas\Soap\Server;
require __DIR__ . '/../../../vendor/autoload.php';
$soap = new Server('http://url.of.wsdl');
// Set the service class
    $soap->setClass(SoapServerClass::class);
// or bind an instance: $soap->setObject(new SoapServerClass());

// Handle request
$soap->handle();