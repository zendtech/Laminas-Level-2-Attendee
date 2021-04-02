<?php
namespace RestApi\Controller\Factory;
use RestApi\Domain\ApiDomain;
use RestApi\Controller\ApiController;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ApiControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new ApiController($container->get(ApiDomain::class));
    }
}
