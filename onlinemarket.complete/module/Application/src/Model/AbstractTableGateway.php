<?php
namespace Application\Model;

use Laminas\Db\TableGateway\TableGatewayInterface;

abstract class AbstractTableGateway
{
    protected $tableGateway;
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
}
