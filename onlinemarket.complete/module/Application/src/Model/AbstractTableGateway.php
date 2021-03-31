<?php
namespace Application\Model;

abstract class AbstractTableGateway
{
    protected $tableGateway;
    public function __construct($tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
}