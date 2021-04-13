<?php
namespace Events\TableModule\Controller;

use Events\ModelModule\Model\ {EventModel, RegistrationModel, AttendeeModel};

trait ModelTrait
{
    protected $eventModel;
    protected $registrationModel;
    protected $attendeeModel;
    public function setEventModel($model)
    {
        $this->eventModel = $model;
    }
    public function setRegistrationModel($model)
    {
        $this->registrationModel = $model;
    }
    public function setAttendeeModel($model)
    {
        $this->attendeeModel = $model;
    }
}
