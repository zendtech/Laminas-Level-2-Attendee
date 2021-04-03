<?php
namespace Events\Model;
use Laminas\Db\{
    Adapter\Adapter,
    TableGateway\TableGateway,
    ResultSet\HydratingResultSet
};
use Psr\Container\ContainerInterface;
use Laminas\Hydrator\ObjectPropertyHydrator;

//*** DELEGATING HYDRATOR LAB: add the correct "use" statements
class BaseEventsTableModel implements EventsTableGatewayInterface
{
    public static $tableName;
    protected $tableGateway, $container;
    //*** DELEGATING HYDRATOR LAB: have the base class accept a DelegatingHydrator instance added as the last argument
    public function __construct(
        Adapter $adapter,
        $entity,
        ContainerInterface $container
    )
    {
        // DELEGATING HYDRATOR LAB: use the hydrator injected
        $resultSet = new HydratingResultSet(new ObjectPropertyHydrator(), $entity);
        // sets up TableGateway to produce instances of get_class($entity) when queried
        $this->tableGateway = new TableGateway(static::$tableName, $adapter, NULL, $resultSet);
        $this->container = $container;
    }
}
