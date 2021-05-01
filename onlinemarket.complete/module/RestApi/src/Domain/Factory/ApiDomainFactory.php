<?php
namespace RestApi\Domain\Factory;
use Model\Model\ListingsModel;
use RestApi\Domain\ApiDomain;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ApiDomainFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new ApiDomain(
            $container->get(ListingsModel::class)
        );
    }
}
