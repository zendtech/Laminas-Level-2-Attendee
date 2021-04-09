<?php
namespace Events\Traits;

use Events\Model\{
    AttendeeTableModel,
    EventTableModel,
    RegistrationTableModel
};

trait RegistrationModelTrait
{
    protected $regTable;
    public function setRegistrationTable(RegistrationTableModel $table)
    {
        $this->regTable = $table;
    }
}
