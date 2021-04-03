<?php
/**
 * Code Runner
 */
use src\modWebServices\XmlRpc\Greeter;
use Zend\XmlRpc\Server;
require __DIR__ . '/../../../vendor/autoload.php';
$server = new Server;
$server->setClass(Greeter::class);
return $server->handle();
