<?php
namespace Application\Model;

use Laminas\Hydrator\ClassMethods;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\TableGateway\TableGateway;

abstract class AbstractTable
{
    public const TABLE_NAME = '';
    protected $tableGateway;
    public function setTableGateway(Adapter $adapter, AbstractModel $model)
    {
        $prototype = new HydratingResultSet(new ClassMethods(), $model);
        $this->tableGateway = new TableGateway(static::TABLE_NAME, $adapter, NULL, $prototype);
    }
    public function findAll()
    {
        return $this->tableGateway->select();
    }
    public function findById($id)
    {
        return $this->tableGateway->select(['id' => $id])->current();
    }
    abstract public function save(AbstractModel $model);
}
