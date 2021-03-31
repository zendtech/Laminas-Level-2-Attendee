<?php
namespace AccessControl;
use AccessControl\Listener\AclListenerAggregate;
class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                AclListenerAggregate::class => function ($container) {
                    return new AclListenerAggregate(
                        $container->get('access-control-guestbook-acl'),
                        $container->get('login-auth-service')
                    );
                },
            ],
        ];
    }

}
