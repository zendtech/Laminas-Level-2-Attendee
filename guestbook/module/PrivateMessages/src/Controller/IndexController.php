<?php
namespace PrivateMessages\Controller;

use Login\Model\UserEntity;
use Application\Traits\SessionTrait;
use PrivateMessages\Form\SendForm as SendForm;
use PrivateMessages\Model\ {MessageModel, MessagesTable};
use Laminas\Form\FormInterface;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Authentication\AuthenticationService;

class IndexController extends AbstractActionController
{
    use SessionTrait;
    const FORM_INVALID  = '<b style="color:orange;">There were invalid form entries: please review error messages</b>';
    const SEND_SUCCESS   = '<b style="color:green;">MessageModel sent successfully</b>';
    const SEND_FAIL      = '<b style="color:red;">Unable to send message</b>';
    const SEND_START     = '<b style="color:gray;">Press "SEND" when ready to send a new message</b>';

    protected $table;
    protected $sendForm;
    protected $authService;
    protected $message;

    public function __construct(
        MessagesTable $messagesTable,
        FormInterface $sendForm,
        AuthenticationService $authService,
        $container
    )
    {
        $this->table = $messagesTable;
        $this->sendForm = $sendForm;
        $this->authService = $authService;
        $this->setSessionContainer($container);
    }
    public function indexAction()
    {
        if (!$this->authService->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        } else {
            $user = $this->authService->getIdentity();
        }        
        $from = $this->sendForm->get('fromEmail');
        $from->setAttribute('value', $user->getEmail());
        $message = $this->session->message ?? '';
        return $this->setViewModel($user, $message);
    }    
    public function sendAction()
    {
        if (!$this->authService->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        } else {
            $user = $this->authService->getIdentity();
        }
        $status = self::SEND_START;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->sendForm->bind(new MessageModel());
            $this->sendForm->setData($request->getPost());
            if (!$this->sendForm->isValid()) {
                $status = self::FORM_INVALID;
            } else {
                $message = $this->sendForm->getData();
                if ($this->table->save($message)) {
                    $status = self::SEND_SUCCESS;
                    $this->redirect()->toRoute('messages');
                } else {
                    $status = self::SEND_FAIL;
                }
            }
        }
        $this->session->message = $status;
        return $this->setViewModel($user, $status);
    }
    protected function setViewModel($user, $status)
    {
        $viewModel = new ViewModel(
            [
                'sendForm' => $this->sendForm,
                'sentMessages' => $this->table->findMessagesSent($user->getEmail()),
                'receivedMessages' => $this->table->findMessagesReceived($user->getEmail()),
                'identity' => $this->authService->getIdentity(),
                'locale' => $user->getLocale() ?? UserEntity::DEFAULT_LOCALE,
            ]
        );
        $viewModel->setTemplate('private-messages/index/index');
        return $viewModel;
    }
}
