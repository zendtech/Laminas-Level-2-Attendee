<?php
/**
 * AttendeeTable
 */
namespace src\modDatabaseModeling\Relationships;
class AttendeeTable extends BaseTable
{
    public static $tableName = 'attendee';
    public function findByRegId($regId)
    {
        return $this->tableGateway->select(['registration_id' => $regId]);
    }
    public function save(AttendeeEntity $attendee)
    {
        $hydrator = $this->tableGateway->getResultSetPrototype()->getHydrator();
        return $this->tableGateway->insert($hydrator->extract($attendee));
    }
}