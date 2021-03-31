<?php
namespace Login\Model\Factory;
use Login\Model\UsersModel;
use Login\Entity\UserEntity;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class UsersModelFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new UsersModel($container->get('login-db-adapter'), new UserEntity());
    }
}