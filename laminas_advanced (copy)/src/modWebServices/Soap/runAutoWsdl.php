<?php
/**
 * Code Runner
 */
use src\modWebServices\Soap\SoapServerClass;
use Zend\Soap\AutoDiscover;
require __DIR__ . '/../../../vendor/autoload.php';

$autodiscover = new AutoDiscover();
// Set the service class
$autodiscover->setClass(SoapServerClass::class)
    ->setUri('http://url.of.soapserver/')
    ->setServiceName('SOAP Service');
$wsdl = $autodiscover->generate();

// Emit the XML:
echo $wsdl->toXml();

// Or dump it to a file; this is a good way to cache the WSDL
// $wsdl->dump("file.wsdl");
