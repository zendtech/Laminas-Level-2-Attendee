<?php
namespace RestApi\Service;
use Events\TableModule\Model\ {EventModel, RegistrationTable, AttendeeTable};
trait TableTrait
{
    protected $eventTable, $regTable, $attendeeTable;

    public function setEventTable(EventModel $table)
    {
        $this->eventTable = $table;
        return $this;
    }
    public function getEventTable()
    {
        return $this->eventTable;
    }
    public function setRegistrationTable(RegistrationTable $table)
    {
        $this->registrationTable = $table;
        return $this;
    }
    public function getRegistrationTable()
    {
        return $this->registrationTable;
    }
    public function setAttendeeTable(AttendeeTable $table)
    {
        $this->attendeeTable = $table;
        return $this;
    }
    public function getAttendeeTable()
    {
        return $this->attendeeTable;
    }
}
