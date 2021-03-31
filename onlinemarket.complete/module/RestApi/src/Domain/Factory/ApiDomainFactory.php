<?php
namespace RestApi\Domain\Factory;
use Model\Model\UsersModel;
use RestApi\Domain\ApiDomain;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ApiDomainFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new ApiDomain(
            $container->get(UsersModel::class)
        );
    }
}