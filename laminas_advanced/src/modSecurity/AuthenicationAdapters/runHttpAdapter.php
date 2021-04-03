<?php
/**
 * Code Runner
 */
use Laminas\Authentication\Adapter\Http;
use Laminas\Authentication\Adapter\Http\FileResolver;
use Laminas\Http\{Request, Response};
require __DIR__ . '/../../../vendor/autoload.php';
$config = require '../../config/config.php';

//Simulate a request
$request = new Request();
$request->setMethod(Request::METHOD_POST);
$request->setUri('/foo');
$request->getHeaders()->addHeaders([
    'HeaderField1' => 'header-field-value1',
    'HeaderField2' => 'header-field-value2',
]);
$request->getPost()->set('foo', 'bar');

try{
    $httpAdapter = new Http($config['auth_adapters']['http']);
    $resolver  = new FileResolver('keyfile');
    $httpAdapter->setBasicResolver($resolver);
    $httpAdapter->setRequest($request);
    $httpAdapter->setResponse(new Response);
    $result = $httpAdapter->authenticate();
} catch (Throwable $e){
    echo $e->getMessage();
}
