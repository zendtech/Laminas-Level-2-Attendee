<?php
namespace Events\TableModule\Model;
use Laminas\Db\{
    Adapter\AdapterInterface,
    TableGateway\TableGateway,
};
interface BaseModelInterface
{
    public function __construct(AdapterInterface $adapter);
    public function getTableGateway() : TableGateway;
}
