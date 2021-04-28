<?php
namespace Login;

use Model\Table\UsersTable;
use Login\Auth\CustomStorage;
use Login\Security\Password;
use Laminas\Mvc\MvcEvent;
use Laminas\Db\Adapter\Adapter;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\Adapter\DbTable\CallbackCheckAdapter;
use Laminas\Crypt\Password\Bcrypt;

//*** AUTHENTICATION LAB: add required "use" statements


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
                //*** PASSWORD LAB: modify this to use "verify()" from the Password class
                'login-auth-callback' => function ($hash, $password) {
                    return '???';
                },
            ],
            'factories' => [
                //*** AUTHENTICATION LAB: define an authentication adapter
                'login-auth-adapter' => function ($container) {
                    //*** AUTHENTICATION LAB: return a CallbackCheckAdapter instance with these arguments:
                    //***                     auth adapter, tablename, identity col, password col and callback
                    return new CallbackCheckAdapter(
                        /* arguments go here */
                    );
                },
                //*** AUTHENTICATION LAB: define authentication service storage
                'login-auth-storage' => function ($container) {
                    return new CustomStorage(/* args go here */);
                },
                'login-auth-service' => function ($container) {
                    //*** AUTHENTICATION LAB: need storage and auth adapter as arguments
                    return new AuthenticationService(
                        /* arguments go here */
                    );
                },
            ],
        ];
    }
}
