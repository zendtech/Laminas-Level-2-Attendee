<?php
namespace Events\Model;

use Events\Entity\AttendeeEntity;

class AttendeeTableModel extends BaseEventsTableModel
{
    public static $tableName = 'attendee';
    public function findByRegistrationId($registrationId)
    {
        return $this->tableGateway->select(['registration_id' => $registrationId]);
    }
    public function save(AttendeeEntity $attendeeEntity)
    {
        $hydrator = $this->tableGateway->getResultSetPrototype()->getHydrator();
        return $this->tableGateway->insert($hydrator->extract($attendeeEntity));
    }
}