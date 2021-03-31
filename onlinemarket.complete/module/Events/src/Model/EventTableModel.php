<?php
namespace Events\Model;

class EventTableModel extends BaseTableModel
{
    public const TABLE_NAME = 'event';
    public function findAll()
    {
        return $this->tableGateway->select();
    }
    public function findById($id)
    {
        return $this->tableGateway->select(['id' => $id])->current();
    }
}