<?php
namespace Events\Traits;

use Events\Model\{
    AttendeeTableModel,
    EventTableModel,
    RegistrationTableModel
};

trait EventModelTrait
{
    protected $eventTable;
    public function setEventTable(EventTableModel $table)
    {
        $this->eventTable = $table;
    }
}
