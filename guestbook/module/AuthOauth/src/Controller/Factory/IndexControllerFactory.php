<?php
namespace AuthOauth\Controller\Factory;
use AuthOauth\Controller\IndexController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new IndexController(
            $container->get('auth-oauth-service'),
            $container->get('auth-oauth-adapter-google'));
    }
}
