<?php
namespace Events\Controller;
use Events\Model\EventsTableGatewayInterface;
use Events\Module;
use Events\Entity\ {RegistrationEntity, AttendeeEntity};
use Events\Traits\ {EventModelTrait, RegistrationModelTrait, AttendeeModelTrait, RegistrationFormTrait};
use Laminas\Filter\FilterInterface;
use Laminas\Form\FormInterface;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class SignUpController extends AbstractActionController
{
    protected $filter;
    use EventModelTrait, RegistrationModelTrait, AttendeeModelTrait, RegistrationFormTrait;

    public function __construct(
        EventsTableGatewayInterface $eventModel,
        EventsTableGatewayInterface $registrationModel,
        EventsTableGatewayInterface $attendeeModel,
        FilterInterface $filter,
        FormInterface $form
    ) {
        $this->setEventTable($eventModel);
        $this->setRegistrationTable($registrationModel);
        $this->setAttendeeTable($attendeeModel);
        $this->filter = $filter;
        $this->setRegistrationForm($form);
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

        $vm->setTemplate('events/signup/registration-form.phtml');
        if ($this->request->isPost()) {
            $vm->setTemplate('events/signup/thanks.phtml');
            if ($this->processForm($this->params()->fromPost(), $eventId)) {
				$message = 'Successfully added registration';
			} else {
				$message = 'Sorry! Unable to add registration';
			}
			$vm->setVariable('message', $message);
        }
        return $vm;
    }

	//*** DATABASE TABLE MODULE RELATIONSHIPS LAB: define this method such that for any given event, registrations and associated attendees are saved
    protected function processForm(array $formData, $eventId)
    {
		$result = FALSE;
		$this->setBindings($eventId);
        $this->regForm->setData($formData);
        if ($this->regForm->isValid()) {
			$registration = $this->regForm->getData();
			$result = $regId = $this->regTable->save($registration);
			foreach ($formData['name_on_ticket'] as $name) {
				if ($name) $this->attendeeTable->save(new AttendeeEntity(['registration_id' => $regId, 'name_on_ticket' => $name]));
			}
		}
		return $result;
    }

	protected function setBindings($eventId)
	{
	    $container = $this->getEvent()->getApplication()->getServiceManager();
	    $registrationEntity = $container->get(RegistrationEntity::class)->setEventID($eventId);
		$this->registrationForm->bind($registrationEntity);

		for ($x = 0; $x < Module::MAX_NAMES_PER_TICKET; $x++) {
			$sub = $this->registrationForm->get('attendee_' . $x);
			$attendeeEntity = $container->get(AttendeeEntity::class);
			$sub->bind($attendeeEntity);
		}
	}
	
    protected function sanitizeData(array $data)
    {
        $clean  = array();
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
