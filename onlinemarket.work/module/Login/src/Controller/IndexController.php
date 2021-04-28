<?php
namespace Login\Controller;

use Application\Model\AbstractTableGateway;
use Login\Event\LoginEvent;
use Model\Entity\UserEntity;
use Translation\Listener\Event;
use Laminas\Form\FormInterface;
use Laminas\Log\Logger;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Authentication\AuthenticationService;

class IndexController extends AbstractActionController
{
    const LOGIN_SUCCESS   = '<b style="color:green;">Login was successful</b>';
    const LOGIN_FAIL      = '<b style="color:red;">Login failed</b>';
    const FORM_INVALID    = '<b style="color:orange;">There were invalid form entries: please review error messages</b>';
    const EVENT_SOMETHING = 'logging-log-something';
    protected $loginForm, $usersModelTableGateway, $authenticationService, $userEntity;

    public function __construct(
        AbstractTableGateway $usersModelTableGateway,
        FormInterface $loginForm,
        AuthenticationService $service,
        UserEntity $userEntity
    ){
        $this->usersModelTableGateway = $usersModelTableGateway;
        $this->loginForm = $loginForm;
        $this->authenticationService = $service;
        $this->userEntity = $userEntity;
    }

    public function indexAction()
    {
        return new ViewModel(['loginForm' => $this->loginForm, 'message' => '']);
    }

    public function loginAction()
    {
        $message = '';
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->loginForm->bind($this->userEntity);
            $this->loginForm->setData($request->getPost());
            if (!$this->loginForm->isValid()) {
                $message = self::FORM_INVALID;
            } else {
                $userEntity = $this->loginForm->getData();
                //*** AUTHENTICATION LAB: get the login adapter from the authentication service, set identity and credential and authenticate into $result
                /* auth adapter */
                /* set identity */
                /* set credentials */
                $result = '???'; // authenticate
                if ($result->isValid()) {
                    /**
                     * AUTHENTICATION LAB: This retrieves the row object omitting the "password" column (don't want that to appear in storage).
                     * The getResultRowObject() method returns a stdClass instance, then the entities constructor sets properties into the entity object by iteration.
                     */
                    $userEntity = new UserEntity(/* args go here */);

                    //*** AUTHENTICATION LAB: Retrieves the storage service, and writes the entity to authentication storage
                    /* get storage */
                    /* write UserEntity to storage */

                    // success message
                    $message = self::LOGIN_SUCCESS;
                    $this->logMessage(Logger::INFO, self::LOGIN_SUCCESS . ':' . $userEntity->getEmail());
                    return $this->redirect()->toRoute('home');
                } else {
                    $message = self::LOGIN_FAIL . '<br>' . implode('<br>', $result->getMessages());
                    $this->logMessage(Logger::WARN, $message);
                }
            }
            //*** to use this plugin, install it: "composer require laminas/laminas-mvc-plugin-flashmessenger"
            $this->flashMessenger()->addMessage($message);
        }
        $message = $message ?: implode('<br>', $this->flashMessenger()->getMessages());
        $viewModel = new ViewModel(['loginForm' => $this->loginForm,
                                    'message' => $message]);
        $viewModel->setTemplate('login/index/index');
        $this->getEventManager()->trigger(LoginEvent::EVENT_LOGIN_VIEW, $this, ['viewModel' => $viewModel]);
        return $viewModel;
    }
    public function logoutAction()
    {
        $this->authenticationService->clearIdentity();
        return $this->redirect()->toRoute('market');
    }
    protected function logMessage($level, $message)
    {
        $this->getEventManager()
             ->trigger( self::EVENT_SOMETHING,
                        $this,
                        ['level' => Logger::INFO, 'message' => $message]
        );
    }
}
