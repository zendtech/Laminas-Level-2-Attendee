<?php
namespace Events\Traits;

trait AttendeeModelTrait
{
    protected $attendeeTable;
    public function setAttendeeTable($table)
    {
        $this->attendeeTable = $table;
    }
}
