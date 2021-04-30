<?php
/**
 * Code Runner
 */
require __DIR__ . '/../../../vendor/autoload.php';
include __DIR__ . '/Greeter.php';
use Laminas\XmlRpc\Server;
$server = new Server;
$server->setClass('Greeter');
try {
    return $server->handle();
} catch (Throwable $t) {
    error_log($t->getMessage());
}
