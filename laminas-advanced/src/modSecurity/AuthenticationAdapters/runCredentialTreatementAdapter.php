<?php
/**
 * Code Runner
 */
use Laminas\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;
use Laminas\Db\Adapter\Adapter;

require __DIR__ . '/../../../vendor/autoload.php';
$config = require '../../config/config.php';
try{
    $credentialTreatmentAdapter = new CredentialTreatmentAdapter(
        new Adapter($config['db'])
    );

    $credentialTreatmentAdapter
        ->setTableName('users')
        ->setIdentityColumn('username')
        ->setCredentialColumn('password')
        ->setIdentity('daryl')
        ->setCredential('$2y$10$Gy8fTpy1K.0Hy1iCf4S6ee5z0Hi6GUARoDHwnAf8EKIRA.XrRLIma');
    $result = $credentialTreatmentAdapter->authenticate();
    var_dump($result);
} catch (Throwable $e){
    echo $e->getMessage();
}


