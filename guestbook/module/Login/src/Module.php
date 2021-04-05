<?php
namespace Login;
use Login\Model\UsersModel;
use Laminas\Mvc\MvcEvent;
use Laminas\Db\Adapter\Adapter;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\Adapter\DbTable\CallbackCheckAdapter;
class Module
{
    const VERSION = '3.0.3-dev';
    public function onBootstrap(MvcEvent $event)
    {
        $eventManager = $event->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'injectAuthService'], 999);
    }

    public function injectAuthService(MvcEvent $event)
    {
        $container = $event->getApplication()->getServiceManager();
        $layout = $event->getViewModel();
        $layout->setVariable('authService', $container->get('login-auth-service'));
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'aliases' => [
                'Laminas\Authentication\AuthenticationService' => 'login-auth-service',
            ],
            'factories' => [
                'login-db-adapter' => function ($container) {
                    return new Adapter($container->get('local-db-Config'));
                },
                'login-auth-adapter' => function ($container) {
                    return new CallbackCheckAdapter(
                        $container->get('login-db-adapter'),
                        UsersModel::TABLE_NAME,
                        UsersModel::IDENTITY_COL,
                        UsersModel::PASSWORD_COL,
                        function ($hash, $password) {
                            if (strlen($hash) == 32) return $hash == md5($password);
                            else return \Login\Security\PasswordSecurity::verify($password, $hash);
                        });
                },
                'login-auth-service' => function ($container) {
                    return new AuthenticationService();
                },
            ],
        ];
    }
}
