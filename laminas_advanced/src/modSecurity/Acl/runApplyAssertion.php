<?php
/**
 * Code Runner
 */
use src\modSecurity\Acl\DateTimeAssertion;
use Zend\Permissions\Acl\Acl;
require __DIR__ . '/../../../vendor/autoload.php';
try {
    $start = new DateTime($config['start_time']);
    $stop  = new DateTime($config['stop_time']);
    $stop->add(new DateInterval('PT5M'));
} catch (Throwable $e) {
    // Handle
}

$acl = new Acl();
$acl->addRole('user');
$acl->addResource('z');

// apply the assertion as the 4th argument to "attach()"
$dtAssertion = new DateTimeAssertion($start, $stop);
$acl->allow('user', 'z', 'access', $dtAssertion);

echo ($acl->isAllowed('user','z','access')) ? 'ALLOWED' : 'DENIED';