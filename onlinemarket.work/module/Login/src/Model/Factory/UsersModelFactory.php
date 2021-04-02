<?php
namespace Login\Model\Factory;

use Model\Entity\User;
use Login\Model\UsersModel;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Hydrator\ClassMethods;

class UsersModelFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new UsersModel($container->get('login-db-adapter'), new User(), new ClassMethods());
    }
}
