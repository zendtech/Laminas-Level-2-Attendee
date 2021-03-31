<?php
namespace Events\Model;
use Zend\Db\{
    Adapter\AdapterInterface,
    ResultSet\ResultSetInterface
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
        $container,
        ResultSetInterface $resultSet,
        $tableGateway
    )
    {
        $this->adapter = $adapter;
        $this->entity = $entity;
        $this->container = $container;
        $this->resultSet = $resultSet;
        $this->tableGateway = $tableGateway;
    }
}