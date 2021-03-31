<?php

namespace Events\Model\Factory;

use Events\Model\BaseEventsTableModel;
use Interop\Container\ContainerInterface;
use Zend\Db\ {
    ResultSet\HydratingResultSet,
    TableGateway\TableGateway
};
use Zend\ServiceManager\Factory\FactoryInterface;

class BaseTableModelFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entity = $container->get('EventEntity::class');
        $adapter = $container->get('model-primary-adapter');
        $resultSet = new HydratingResultSet(
            new ObjectPropertyHydrator(),
            $entity
        );
        return new BaseEventsTableModel(
            $adapter,
            $entity,
            $container,
            $resultSet,
            new TableGateway(
                static::$tableName,
                $adapter,
                NULL,
                $resultSet
            )
        );
    }
}