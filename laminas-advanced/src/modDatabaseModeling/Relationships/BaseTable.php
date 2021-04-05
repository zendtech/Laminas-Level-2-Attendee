<?php
/**
 * Base
 */
namespace src\modDatabaseModeling\Relationships;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Hydrator\ObjectProperty;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\TableGateway\TableGateway;
class BaseTable {
    public static $tableName;
    protected $tableGateway;
    public function __construct(Adapter $adapter, $entity) {
        $resultSet = new HydratingResultSet(new ObjectProperty, $entity);
        $this->tableGateway = new TableGateway(static::$tableName, $adapter, NULL, $resultSet);
    }
}