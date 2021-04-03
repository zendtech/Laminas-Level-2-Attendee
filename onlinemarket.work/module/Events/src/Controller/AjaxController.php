<?php
namespace Events\Controller;

use Events\Traits\{RegistrationModelTrait, AttendeeModelTrait};
use Events\Model\EventsTableGatewayInterface;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;

class AjaxController extends AbstractActionController
{
    use RegistrationModelTrait, AttendeeModelTrait;
    public function __construct(
        EventsTableGatewayInterface $registrationModel,
        EventsTableGatewayInterface $attendeeModel
    ){
        $this->setRegistrationTable($registrationModel);
        $this->setAttendeeTable($attendeeModel);
    }

	//*** DATABASE TABLE MODULE RELATIONSHIPS LAB: [OPTIONAL] only define this if you choose the AJAX approach
    public function registrationAction()
    {
        $eventId = $this->params('eventId');
        $registrations = $this->regTable->findRegByEventId($eventId);
        //*** DATABASE TABLE MODULE RELATIONSHIPS LAB: provide secondary data usersModelTableGateway which performs lookups for attendees for each registration
        $data = [];
        if ($registrations) {
            foreach ($registrations as $item) {
                $secondaryDataTable = '???';
                $data[] = [
                    $item->registration_time,
                    $item->first_name,
                    $item->last_name,
                    $secondaryDataTable];
            }
        }
        return new JsonModel(['data' => $data]);
    }
    public function attendeeAction()
    {
        $regId = $this->params('regId');
        $attendees = $this->attendeeTable->findByRegId($regId);
        $data = [];
        if ($attendees) {
            foreach ($attendees as $item) {
                $data[] = [$item->getNameOnTicket()];
            }
        }
        return new JsonModel(['data' => $data]);
    }
	//*** FORMS AND FIELDSETS LAB: add action method which returns AttendeeEntity sub-form instance with next ticket #
}
