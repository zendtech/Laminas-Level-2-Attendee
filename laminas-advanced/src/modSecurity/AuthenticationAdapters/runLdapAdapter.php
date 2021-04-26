<?php
/**
 * Code Runner
 */
// using https://www.forumsys.com/tutorials/integration-how-to/ldap/online-ldap-test-server/
use Laminas\Authentication\Adapter\Ldap;
require __DIR__ . '/../../../vendor/autoload.php';
$config     = require '../../config/config.php';
$identity   = 'cn=read-only-admin,dc=example,dc=com';
$credential = 'password';
echo '<pre>';
try{
    $ldapAdapter = new Ldap($config['auth_adapters']['ldap'], $identity, $credential);
    $result = $ldapAdapter->authenticate();
    var_dump($result);
} catch (Throwable $e){
    // Handle
    echo $e;
}
echo '</pre>';
