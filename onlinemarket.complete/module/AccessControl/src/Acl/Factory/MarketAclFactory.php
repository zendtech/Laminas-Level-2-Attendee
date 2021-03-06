<?php
namespace AccessControl\Acl\Factory;
use AccessControl\Acl\MarketAcl;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
class MarketAclFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new MarketAcl($container);
    }
}
