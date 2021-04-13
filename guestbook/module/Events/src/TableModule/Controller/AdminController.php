<?php
namespace Events\TableModule\Controller;
use Events\TableModule\Model\BaseModelInterface;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class AdminController extends AbstractActionController
{
    use ModelTrait;
    public function __construct(BaseModelInterface $eventModel, BaseModelInterface $registrationModel) {
        $this->setEventModel($eventModel);
        $this->setRegistrationModel($registrationModel);
    }

    public function indexAction()
    {
        $eventId = $this->params('event');
        if ($eventId) {
            return $this->listRegistrations($eventId);
        }
        $events = $this->eventModel->findAll();
        $viewModel = new ViewModel(array('events' => $events));
        return $viewModel;
    }

    protected function listRegistrations($eventId)
    {
        $registrations = $this->registrationModel->findAllForEvent($eventId);
        $viewModel = new ViewModel(array('registrations' => $registrations));
        $viewModel->setTemplate('events/table-module/admin/list.phtml');
        return $viewModel;
    }
}
