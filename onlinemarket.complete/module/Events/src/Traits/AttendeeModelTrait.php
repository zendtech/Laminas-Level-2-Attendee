<?php
namespace Events\Traits;

use Events\Model\EventsTableGatewayInterface;

trait AttendeeModelTrait
{
    protected $attendeeTable;
    public function setAttendeeTable($table)
    {
        $this->attendeeTable = $table;
    }
}
