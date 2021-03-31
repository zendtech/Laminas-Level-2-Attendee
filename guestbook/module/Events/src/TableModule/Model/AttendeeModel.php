<?php
namespace Events\TableModule\Model;
class AttendeeModel extends BaseModel
{
    public static $tableName = 'attendee';
    public function persist($regId, $name)
    {
        return $this->tableGateway->insert(
            ['registration_id' => $regId,
             'name_on_ticket' => $name]);
    }
}
