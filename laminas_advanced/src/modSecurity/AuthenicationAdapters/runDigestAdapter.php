<?php
/**
 * Code Runner
 */

use Laminas\Authentication\Adapter\Digest;

require __DIR__ . '/../../../vendor/autoload.php';
$config = require '../../config/config.php';

try{
    $digestAdapter = new Digest(
        'keyfile',
        'My Web Site',
        'mark',
        'password'
    );

    $result = $digestAdapter->authenticate();
    $identity = $result->getIdentity();
    var_dump($identity);
} catch (Throwable $e){
    echo $e->getMessage();
}


