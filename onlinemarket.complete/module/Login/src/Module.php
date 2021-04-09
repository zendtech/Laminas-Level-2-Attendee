<?php
namespace Login;
use Laminas\Db\Adapter\Adapter;
use Login\Model\UsersModel;
use Login\Auth\CustomStorageAuthentication;

//*** AUTHENTICATION LAB: add required "use" statements
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\Adapter\DbTable\CallbackCheckAdapter;

//*** PASSWORD LAB: add required "use" statements
use Login\Security\PasswordSecurity;

class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'services' => [
                'login-auth-callback' => function ($hash, $password) {
                    return PasswordSecurity::verify($password, $hash);
                },
            ],
            'factories' => [
                'login-db-adapter' => function ($container) {
                    return new Adapter($container->get('model-primary-adapter-Config'));
                },
                'login-auth-adapter' => function ($container) {
                    return new CallbackCheckAdapter(
                        $container->get('login-db-adapter'),
                        UsersModel::TABLE_NAME,
                        UsersModel::IDENTITY_COL,
                        UsersModel::PASSWORD_COL,
                        $container->get('login-auth-callback')
                    );
                },
                'login-auth-storage' => function ($container) {
                    return new CustomStorageAuthentication($container->get('login-storage-file'));
                },
                'login-auth-service' => function ($container) {
                    return new AuthenticationService(
                        // need storage and auth adapter as arguments
                        $container->get('login-auth-storage'),
                        $container->get('login-auth-adapter'));
                },
            ],
        ];
    }
}
