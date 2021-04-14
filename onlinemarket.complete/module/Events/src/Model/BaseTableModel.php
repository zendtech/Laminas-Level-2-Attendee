<?php
namespace Events\Model;
use Psr\Container\ContainerInterface;
use Laminas\Db\{
    Adapter\AdapterInterface,
    ResultSet\ResultSetInterface,
    TableGateway\TableGatewayInterface,
};
use Events\Entity\EntityInterface;

//*** DELEGATING HYDRATOR LAB: add the correct "use" statements
abstract class BaseTableModel implements EventsTableGatewayInterface
{
    public static $tableName;
    protected $adapter, $entity, $resultSet, $tableGateway, $container;
    //*** DELEGATING HYDRATOR LAB: have the base class accept a DelegatingHydrator instance added as the last argument
    public function __construct(
        AdapterInterface $adapter,
        EntityInterface $entity,
        ContainerInterface $container,
        ResultSetInterface $resultSet,
        TableGatewayInterface $tableGateway
    )
    {
        $this->adapter = $adapter;
        $this->entity = $entity;
        $this->container = $container;
        $this->resultSet = $resultSet;
        $this->tableGateway = $tableGateway;
    }
}
