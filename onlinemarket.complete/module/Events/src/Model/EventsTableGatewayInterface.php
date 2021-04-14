<?php
namespace Events\Model;
use Events\Entity\EntityInterface;
use Psr\Container\ContainerInterface;
use Laminas\Db\ {
    Adapter\AdapterInterface,
    ResultSet\ResultSetInterface,
    TableGateway\TableGatewayInterface,
};

interface EventsTableGatewayInterface
{
    public function __construct(AdapterInterface $adapter,
                                EntityInterface $entity,
                                ContainerInterface $container,
                                ResultSetInterface $resultSet,
                                TableGatewayInterface $tableGateway
    );
}
