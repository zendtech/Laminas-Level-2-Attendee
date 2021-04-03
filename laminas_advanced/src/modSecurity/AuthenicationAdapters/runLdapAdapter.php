<?php
/**
 * Code Runner
 */
use Zend\Authentication\Adapter\Ldap;
require __DIR__ . '/../../../vendor/autoload.php';
$config = require '../../config/config.php';
try{
    $ldapAdapter = new Ldap($config['auth_adapters']['ldap'], 'username', 'password');
    $result = $ldapAdapter->authenticate();
} catch (Throwable $e){
    // Handle
}