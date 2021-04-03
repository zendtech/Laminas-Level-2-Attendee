<?php
namespace Events\Controller;
use Events\Traits\ {EventModelTrait, RegistrationModelTrait};
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class AdminController extends AbstractActionController
{

    use EventModelTrait;
    use RegistrationModelTrait;

    public function __construct(
        TableGatewayInterface $eventTable,
        TableGatewayInterface $registrationTable
    ) {
        $this->setEventTable($eventTable);
        $this->setRegistrationTable($registrationTable);
    }

    public function indexAction()
    {
        $eventId = $this->params()->fromRoute('eventId', FALSE);
        if ($eventId) {
			//*** DATABASE TABLE MODULE RELATIONSHIPS LAB: use any of the approaches covered in the slides to provide a list of registrations and associated attendees for a given event
			$registrations = $this->regTable->findAllForEvent($eventId);
            $viewModel = new ViewModel(['registrations' => $registrations]);
            $viewModel->setTemplate('events/admin/list');
        } else {
            $events = $this->eventTable->findAll();
            $viewModel = new ViewModel(['events' => $events]);
        }
        return $viewModel;
    }
}
