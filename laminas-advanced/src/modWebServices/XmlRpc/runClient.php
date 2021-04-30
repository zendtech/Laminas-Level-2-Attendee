<?php
/**
 * Code Runner
 */
$url = 'http://localhost:8080';
//$url = 'http://10.20.30.30/xmlrpc';
require __DIR__ . '/../../../vendor/autoload.php';
use Laminas\XmlRpc\Client\Exception\FaultException;
use Laminas\XmlRpc\Client;
use Laminas\XmlRpc\Value\Text;
try {
    $client = new Client($url);
    echo $client->call('hello');

    // output: "Hello Stranger!"
    echo $client->call('hello', new Text('Dude'));

    // output: "Hello Dude!"
    // NOTE: you could also run $proxy = $client->getProxy()
    //       and make calls through the proxy
} catch (FaultException $e) {
    error_log('<pre>' . $e->getMessage() . '</pre>');
}
