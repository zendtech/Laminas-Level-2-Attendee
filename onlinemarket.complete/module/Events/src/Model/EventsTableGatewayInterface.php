<?php
namespace Events\Model;
use Events\Entity\EntityInterface;
use Psr\Container\ContainerInterface;
use Zend\Db\ {
    Adapter\AdapterInterface,
    ResultSet\ResultSetInterface,
};

interface EventsTableGatewayInterface
{
    public function __construct(AdapterInterface $adapter,
                                EntityInterface $entity,
                                $container,
                                ResultSetInterface $resultSet,
                                $tableGateway
    );
}