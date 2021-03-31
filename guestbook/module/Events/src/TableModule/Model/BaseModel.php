<?php
namespace Events\TableModule\Model;
use Zend\Db\{
    Adapter\AdapterInterface,
    TableGateway\TableGateway,
};
abstract class BaseModel
{
    public $tablename;
    protected $tableGateway;
    public function __construct(AdapterInterface $adapter)
    {
        $this->tableGateway = new TableGateway(static::$tablename, $adapter);
    }
    public function getTableGateway()
    {
        return $this->tableGateway;
    }
}
