<?php
//*** ACL LAB
namespace AccessControl;
use AccessControl\Acl\MarketAcl;
use AccessControl\Listener\AclListenerAggregate;
use Interop\Container\ContainerInterface;

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
                AclListenerAggregate::class => function (ContainerInterface $container) {
                    return new AclListenerAggregate(
                        $container->get(MarketAcl::class),
                        $container->get('login-auth-service')
                    );
                },
            ],
        ];
    }

}
