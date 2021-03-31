<?php
namespace Events\TableModule\Controller;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AdminController extends AbstractActionController
{
    use TableTrait;
    public function __construct(TableGatewayInterface $eventTable, TableGatewayInterface $registrationTable) {
        $this->setEventTable($eventTable);
        $this->setRegistrationTable($registrationTable);
    }

    public function indexAction()
    {
        $eventId = $this->params('event');
        if ($eventId) {
            return $this->listRegistrations($eventId);
        }
        $events = $this->eventTable->findAll();
        $viewModel = new ViewModel(array('events' => $events));
        return $viewModel;
    }

    protected function listRegistrations($eventId)
    {
        $registrations = $this->registrationTable->findAllForEvent($eventId);
        $viewModel = new ViewModel(array('registrations' => $registrations));
        $viewModel->setTemplate('events/table-module/admin/list.phtml');
        return $viewModel;
    }
}
