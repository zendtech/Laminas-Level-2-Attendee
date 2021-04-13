<?php
namespace Events\TableModule\Controller\Factory;
use Events\TableModule\Controller\AdminController;
use Events\TableModule\Model\{EventModel, RegistrationModel};
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class AdminControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new AdminController($container->get(EventModel::class), $container->get(RegistrationModel::class));
    }
}
