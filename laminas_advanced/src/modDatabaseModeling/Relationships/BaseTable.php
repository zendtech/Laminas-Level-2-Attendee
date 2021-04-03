<?php
/**
 * Base
 */
namespace src\modDatabaseModeling\Relationships;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Hydrator\ObjectProperty;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
class BaseTable {
    public static $tableName;
    protected $tableGateway;
    public function __construct(Adapter $adapter, $entity) {
        $resultSet = new HydratingResultSet(new ObjectProperty, $entity);
        $this->tableGateway = new TableGateway(static::$tableName, $adapter, NULL, $resultSet);
    }
}