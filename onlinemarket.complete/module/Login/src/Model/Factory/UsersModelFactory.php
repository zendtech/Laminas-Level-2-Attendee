<?php
namespace Login\Model\Factory;

use Model\Entity\UserEntity;
use Login\Model\UsersModel;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Hydrator\ClassMethodsHydrator;
use Zend\Db\TableGateway\TableGateway;

class UsersModelFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $adapter = $container->get('login-db-adapter');
        return new UsersModel(
            $adapter,
            new UserEntity(),
            new ClassMethodsHydrator(),
            new TableGateway(
                UsersModel::TABLE_NAME,
                $adapter,
                NULL
            )
        );
    }
}
