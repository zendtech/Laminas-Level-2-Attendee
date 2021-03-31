<?php

namespace AccessControl\Acl\Factory;
use AccessControl\Acl\GuestbookAcl;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class GuestbookAclFactory implements FactoryInterface {
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null) {
        return new GuestbookAcl($container->get('Config')['access-control-config'], $container);
    }
}
