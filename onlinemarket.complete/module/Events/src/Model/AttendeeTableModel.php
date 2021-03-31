<?php
namespace Events\Model;

use Events\Entity\EntityInterface;

class AttendeeTableModel extends BaseTableModel
{
    public const TABLE_NAME = 'attendee';
    public function findByRegistrationId($registrationId)
    {
        return $this->tableGateway->select(['registration_id' => $registrationId]);
    }
    public function save(EntityInterface $attendeeEntity)
    {
        $hydrator = $this->tableGateway->getResultSetPrototype()->getHydrator();
        return $this->tableGateway->insert($hydrator->extract($attendeeEntity));
    }
}