<?php
/**
 * Code Runner
 */
use Laminas\Http\PhpEnvironment\Response;
require __DIR__ . '/../../../vendor/autoload.php';

$response = new Response();
$response->setStatusCode(406);

// Adding a response header:
$headers = $response->getHeaders();
$headers->addHeaderLine('X-Foo-Bar', 'BAZ!');