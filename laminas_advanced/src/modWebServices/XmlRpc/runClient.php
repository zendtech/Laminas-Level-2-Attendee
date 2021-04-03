<?php
/**
 * Code Runner
 */
require __DIR__ . '/../../../vendor/autoload.php';
use Zend\XmlRpc\Client\Exception\FaultException;
use Zend\XmlRpc\Client;
try {
    $client = new Client('http://localhost:8080');
    echo $client->call('greeter.sayHello');

    // output: "Hello Stranger!"
    echo $client->call('greeter.sayHello', array('Dude'));

    // output: "Hello Dude!"
    // NOTE: you could also run $proxy = $client->getProxy()
    //       and make calls through the proxy
} catch (FaultException $e) {
    error_log($e->getMessage());
}