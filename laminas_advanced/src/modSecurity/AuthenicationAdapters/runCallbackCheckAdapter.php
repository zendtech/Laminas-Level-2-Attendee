<?php
/**
 * Code Runner
 */
use Laminas\Authentication\Adapter\DbTable\CallbackCheckAdapter;
use Laminas\Db\Adapter\Adapter;
require __DIR__ . '/../../../vendor/autoload.php';
$config = require '../../config/config.php';
try{
    $callbackCheckAdapter = new CallbackCheckAdapter(
        new Adapter($config['db'])
    );

    $callback = function ($hash, $password) {
        return password_verify($password, $hash);
    };

    $callbackCheckAdapter
        ->setTableName('users')
        ->setIdentityColumn('username')
        ->setCredentialColumn('password')
        ->setCredentialValidationCallback($callback)
        ->setIdentity('daryl')
        // User raw password
        ->setCredential('password');
    $result = $callbackCheckAdapter->authenticate();
    var_dump($result);
} catch (Throwable $e){
    echo $e->getMessage();
}


