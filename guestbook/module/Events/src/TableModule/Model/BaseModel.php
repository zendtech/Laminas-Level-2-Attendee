<?php
namespace Events\TableModule\Model;
use Laminas\Db\{
    Adapter\AdapterInterface,
    TableGateway\TableGateway,
};
abstract class BaseModel implements BaseModelInterface
{
    public static $tableName = '';
    protected $tableGateway;
    public function __construct(AdapterInterface $adapter)
    {
        $this->tableGateway = new TableGateway(static::$tableName, $adapter);
    }
    public function getTableGateway() : TableGateway
    {
        return $this->tableGateway;
    }
}
