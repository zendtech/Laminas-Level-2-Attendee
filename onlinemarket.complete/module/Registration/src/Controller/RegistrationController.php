<?php
namespace Registration\Controller;
use Application\Model\AbstractTableGateway;
use Model\Entity\UserEntity;
use Model\Traits\UsersModelTrait;
use Zend\Form\FormInterface;
use Zend\Log\Logger;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class RegistrationController extends AbstractActionController
{
    const REG_SUCCESS     = '<b style="color:green;">RegistrationEntity was successful</b>';
    const REG_FAIL        = '<b style="color:red;">RegistrationEntity failed</b>';
    const EVENT_SOMETHING = 'logging-log-something';
    use UsersModelTrait;
    protected $registrationForm, $userEntity;

    public function __construct(
        AbstractTableGateway $usersModelTableGateway,
        FormInterface $registrationForm
    ) {
        $this->setUsersModelTableGateway($usersModelTableGateway);
        $this->registrationForm = $registrationForm;
    }

    public function indexAction()
    {
        $message = '';
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->registrationForm->bind(new UserEntity());
            $this->registrationForm->setData($request->getPost());
            if (!$this->registrationForm->isValid()) {
                $message = self::REG_FAIL;
				//*** LOGGER LAB: log a warning message
                $this->logMessage(Logger::WARN, __METHOD__ . ':' . self::REG_FAIL . ':' . var_export($this->registrationForm->getMessages(), TRUE));
            } else {
                $user = $this->registrationForm->getData();
                if ($this->usersModelTableGateway->save($user)) {
					//*** LOGGER LAB: log an info message
					$this->logMessage(Logger::INFO, __METHOD__ . ':' . self::REG_SUCCESS . ':' . $user->getEmail());
                    $this->flashMessenger()->addMessage(self::REG_SUCCESS);
                    return $this->redirect()->toRoute('home');
                } else {
                    $message = self::REG_FAIL . '<br>' . implode('<br>', $this->flashMessenger->getMessages());
					//*** LOGGER LAB: log an error message
					$this->logMessage(Logger::ERROR, __METHOD__ . ':' . self::REG_FAIL . ':' . var_export($this->registrationForm->getMessages(), TRUE));
                }
            }
        }
        return new ViewModel(['registrationForm' => $this->registrationForm,
                                    'message' => $message,
									//*** TRANSLATION LAB: set $useLocale = TRUE
                                    'useLocale' => TRUE]);
    }

	protected function logMessage($level, $message)
	{
		//*** LOGGER LAB: triggers an EVENT_SOMETHING event (recognized by the Logger\Listener)
		$this->getEventManager()
		     ->trigger( self::EVENT_SOMETHING, 
						$this, 
						['level' => Logger::INFO, 'message' => $message]
		);
	}
}
