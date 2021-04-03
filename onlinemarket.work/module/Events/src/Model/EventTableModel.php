<?php
namespace Events\Model;
class EventTableModel extends BaseEventsTableModel
{
    public static $tableName = 'event';
    public function findAll()
    {
        return $this->tableGateway->select();
    }
    public function findById($eventId)
    {
        return $this->tableGateway->select(['id' => $eventId])->current();
    }
}
