<?php
namespace Events\Controller;
use Events\Model\EventsTableGatewayInterface;
use Events\Module;
use Notification\Event\NotificationEvent;
use Events\Entity\ {
    RegistrationEntity,
    AttendeeEntity
};
use Events\Traits\ {
    EventModelTrait,
    RegistrationModelTrait,
    AttendeeModelTrait,
    RegistrationFormTrait
};
use Laminas\Filter\FilterInterface;
use Laminas\Form\FormInterface;
use Laminas\Hydrator\HydratorInterface;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class SignUpController extends AbstractActionController
{
    protected $filter, $hydrator;
    use EventModelTrait, RegistrationModelTrait, AttendeeModelTrait, RegistrationFormTrait;

    public function __construct(
        EventsTableGatewayInterface $eventTableModel,
        EventsTableGatewayInterface $registrationTableModel,
        EventsTableGatewayInterface $attendeeTableModel,
        FilterInterface $filter,
        FormInterface $form,
        HydratorInterface $hydrator
    ) {
        $this->setEventTable($eventTableModel);
        $this->setRegistrationTable($registrationTableModel);
        $this->setAttendeeTable($attendeeTableModel);
        $this->filter = $filter;
        $this->setRegistrationForm($form);
        $this->hydrator = $hydrator;
    }

    public function indexAction()
    {
        $eventId = (int) $this->params('eventId', FALSE);
        if ($eventId) {
                        $this->setBindings($eventId);
            return $this->eventSignup($eventId);
        }
        $events = $this->eventTable->findAll();
        return new ViewModel(['events' => $events]);
    }

    public function thanksAction()
    {
        return new ViewModel();
    }

    protected function eventSignup($eventId)
    {
        if (!$event = $this->eventTable->findById($eventId)) {
            return $this->redirect()->toRoute('events/signup');
        }
        //*** FORMS AND FIELDSETS LAB: set the form instance in the viewmodel container
        $vm = new ViewModel([
            'event' => $event,
            'registrationForm' => $this->registrationForm
        ]);

        if ($this->request->isPost()) {
            $vm->setTemplate('events/sign-up/thanks.phtml');
            if ($this->processForm($this->params()->fromPost(), $eventId)) {
                $this->getEventManager()->trigger(NotificationEvent::EVENT_NOTIFICATION, $this, ['message' => 'Thank you']);
                                $message = 'Successfully added registration';
                        } else {
                                $message = 'Sorry! Unable to add registration';
                        }
                        $vm->setVariable('message', $message);
        } else {
            $vm->setTemplate('events/sign-up/registration-form.phtml');
        }
        return $vm;
    }

    //*** DATABASE TABLE MODULE RELATIONSHIPS LAB: define this method such that for any given event, registrations and associated attendees are saved
    protected function processForm(array $formData, $eventId)
    {
        $result = FALSE;
        $this->setBindings($eventId);
        $this->registrationForm->setData($formData);
        if ($this->registrationForm->isValid()) {
            $registration = $this->registrationForm->getData();
            $registration->setEventId($eventId);
            $result = $regId = $this->regTable->save($registration);
            foreach ($formData['name_on_ticket'] as $name) {
                if ($name)
                    $this->attendeeTable->save(new AttendeeEntity(['registration_id' => $regId, 'name_on_ticket' => $name]));
        }
    }
    return $result;
    }

    protected function setBindings(int $id)
    {
        $container = $this->getEvent()->getApplication()->getServiceManager();
        $registrationEntity = $container->get(RegistrationEntity::class)->setId($id);
        $this->registrationForm->bind($registrationEntity);
        for ($x = 0; $x < Module::MAX_NAMES_PER_TICKET; $x++) {
            $subForm = $this->registrationForm->get('attendee_' . $x);
            $subForm->setHydrator($this->hydrator);
            $attendeeEntity = $container->get(AttendeeEntity::class);
            $subForm->bind($attendeeEntity);
        }
    }

    protected function sanitizeData(array $data)
    {
        $clean  = [];
        foreach ($data as $key => $item) {
            if (is_array($item)) {
                foreach ($item as $subKey => $subItem) {
                    $clean[$key][$subKey] = $this->filter->filter($subItem);
                }
            } else {
                $clean[$key] = $this->filter->filter($item);
            }
        }
        return $clean;
    }
}
