<?php
use Laminas\Soap\Client;
require __DIR__ . '/../../../vendor/autoload.php';

// Initialize variables
$lat    = 35.1495;   // Memphis, Tennessee (Shelby)
$lon    = -90.0490;
$time   = (new DateTime('now'))->format('Y-m-d');
$numDays = 7;
$unit   = 'm';
$format = '24 hourly';
$wsdl   = 'https://graphical.weather.gov/xml/SOAP_server/ndfdXMLserver.php?wsdl';
$options = [
    'compression'    => SOAP_COMPRESSION_ACCEPT,
    'cache_wsdl'     => WSDL_CACHE_NONE,
    'user_agent'     => 'PHPSoapClient'
];
$soap = new SoapClient($wsdl, $options);
$weather = $soap->NDFDgenByDay($lat,$lon,$time,$numDays,$unit,$format);
echo '<h1>Weather Forecast</h1>';
echo '<h2>Memphis Tennessee, USA</h2>';
echo '<hr>';
echo '<pre>';
echo $weather;
echo '</pre>';
