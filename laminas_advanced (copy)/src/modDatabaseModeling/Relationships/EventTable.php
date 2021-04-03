<?php
/**
 * AttendeeTable
 */
namespace src\modDatabaseModeling\Relationships;
class EventTable extends BaseTable
{
    public static $tableName = 'events';
    public function findAll()
    {
        return $this->tableGateway->select();
    }
    public function findById($eventId)
    {
        return $this->tableGateway->select(['id' => $eventId])->current();
    }
}