<?php
namespace Events\TableModule\Controller;
use Laminas\Filter\FilterInterface;
use Events\TableModule\Model\BaseModel;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class SignupController extends AbstractActionController
{
    use TableTrait;
    protected $regDataFilter;
    public function __construct(BaseModel $eventModel,
                                BaseModel $registrationModel,
                                BaseModel $attendeeModel,
                                FilterInterface $filter)
    {
        $this->setEventModel($eventModel);
        $this->setRegistrationModel($registrationModel);
        $this->setAttendeeModel($attendeeModel);
        $this->setRegDataFilter($filter);
    }
    public function indexAction()
    {
        $eventId = (int) $this->params('event');
        if ($eventId) {
            return $this->eventSignup($eventId);
        }
        $events = $this->eventModel->findAll();
        return new ViewModel(array('events' => $events));
    }

    public function thanksAction()
    {
        return new ViewModel();
    }

    protected function eventSignup($eventId)
    {
        $event = $this->eventModel->findById($eventId);
        if (!$event) {
            return $this->notFoundAction();
        }
        $vm = new ViewModel(array('event' => $event));
        if ($this->request->isPost()) {
            $this->processForm($this->params()->fromPost(), $eventId);
            $vm->setTemplate('events/table-module/signup/thanks.phtml');
        } else {
            $vm->setTemplate('events/table-module/signup/form.phtml');
        }
        return $vm;
    }

    protected function processForm(array $formData, $eventId)
    {
        $formData = $this->sanitizeData($formData);
        $regId = $this->registrationModel->persist($eventId, $formData['first_name'], $formData['last_name']);
        $ticketData = $formData['ticket'];
        foreach ($ticketData as $nameOnTicket) {
            $this->attendeeModel->persist($regId, $nameOnTicket);
        }
        return true;
    }

    protected function sanitizeData(array $data)
    {
        $clean  = array();
        foreach ($data as $key => $item) {
            if (is_array($item)) {
                foreach ($item as $subKey => $subItem) {
                    $clean[$key][$subKey] = $this->regDataFilter->filter($subItem);
                }
            } else {
                $clean[$key] = $this->regDataFilter->filter($item);
            }
        }
        return $clean;
    }

    public function setRegDataFilter(FilterInterface $filter)
    {
        $this->regDataFilter = $filter;
    }
}
