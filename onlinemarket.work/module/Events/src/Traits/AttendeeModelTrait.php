<?php
namespace Events\Traits;

use Events\Model\EventsTableGatewayInterface;

trait AttendeeModelTrait
{
    protected $attendeeTable;
    public function setAttendeeTable(EventsTableGatewayInterface $table)
    {
        $this->attendeeTable = $table;
    }
}
