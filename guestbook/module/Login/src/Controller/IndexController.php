<?php
namespace Login\Controller;
use Login\Entity\UserEntity;
use Application\Model\AbstractTable;
use Application\Traits\SessionTrait;
use Guestbook\Listener\CacheListenerAggregate;
use Laminas\Form\FormInterface;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Authentication\Adapter\ValidatableAdapterInterface;
use Laminas\Session\ManagerInterface;
use Laminas\Session\Container as SessionContainer;

class IndexController extends AbstractActionController
{
    use SessionTrait;
    const LOGIN_INIT    = '<b style="color:gray;">Please requested login information</b>';
    const LOGIN_SUCCESS = '<b style="color:green;">LoginForm was successful</b>';
    const LOGIN_FAIL    = '<b style="color:red;">LoginForm failed</b>';
    const FORM_INVALID  = '<b style="color:orange;">There were invalid form entries: please review error messages</b>';
    const REG_SUCCESS   = '<b style="color:green;">Registration was successful</b>';
    const REG_FAIL      = '<b style="color:red;">Registration failed</b>';
    protected $userTable, $loginForm, $regForm, $authService, $loginAuthAdapter, $sessionContainer;

    public function __construct(
        AbstractTable $userTable,
        FormInterface $regForm,
        FormInterface $loginForm,
        ValidatableAdapterInterface $loginAuthAdapter,
        AuthenticationServiceInterface $authService,
        SessionContainer $sessionContainer,
        ManagerInterface $sessionManager

    ){
        $this->userTable = $userTable;
        $this->regForm   = $regForm;
        $this->loginForm = $loginForm;
        $this->loginAuthAdapter = $loginAuthAdapter;
        $this->authService = $authService;
        $this->setSessionContainer($sessionContainer);
        $this->setSessionManager($sessionManager);
    }

    public function indexAction()
    {
        return new ViewModel(['loginForm' => $this->loginForm,
                              'regForm' => $this->regForm,
                              'message' => '']);
    }
    /**
     * Performs basic login / authentication
     *
     * Additional security suggestions:
     * #1: create a log file of successful and failed login attempts
     * #2: maintain a counter and redirect at random if XXX number of failed login attempts
     *
     */
    public function loginAction()
    {
        $message = NULL;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->loginForm->bind(new UserEntity());
            $this->loginForm->setData($request->getPost());
            if (!$this->loginForm->isValid()) {
                $message = self::FORM_INVALID;
            } else {
                $user = $this->loginForm->getData();
                // save locale from login form
                $locale = $user->getLocale() ?? UserEntity::DEFAULT_LOCALE;
                // otherwise, continue as normal
                $this->loginAuthAdapter->setIdentity($user->getEmail());
                $this->loginAuthAdapter->setCredential($user->getPassword());
                $result = $this->loginAuthAdapter->authenticate();
                if ($result->isValid()) {
                    $storage = $this->authService->getStorage();
                    $user = new UserEntity(get_object_vars($this->loginAuthAdapter->getResultRowObject()));
                    // override locale
                    $user->setLocale($locale);
                    $storage->write($user);
                    $this->sessionContainer->message = self::LOGIN_SUCCESS;
                    $this->getEventManager()->trigger(CacheListenerAggregate::EVENT_CLEAR_CACHE, $this);
                    return $this->redirect()->toRoute('home');
                } else {
                    $message = self::LOGIN_FAIL;
                }
            }
            $this->sessionContainer->message = $message;
        }
        $message = $message ?? $this->sessionContainer->message ?? '';
        $viewModel = new ViewModel(['loginForm' => $this->loginForm,
                                    'regForm' => $this->regForm,
                                    'message' => $message]);
        $viewModel->setTemplate('login/index/index');
        return $viewModel;
    }
    public function logoutAction()
    {
        $this->authService->clearIdentity();
        $this->sessionManager->destroy();
        $this->getEventManager()->trigger(CacheListenerAggregate::EVENT_CLEAR_CACHE, $this);
        return $this->redirect()->toRoute('login');
    }
    public function registerAction()
    {
        $message = '';
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->regForm->bind(new UserEntity());
            $this->regForm->setData($request->getPost());
            if (!$this->regForm->isValid()) {
                $message = self::FORM_INVALID;
            } else {
                $user = $this->regForm->getData();
               if ($this->table->save($user)) {
                    $message = self::REG_SUCCESS;
                } else {
                    $message = self::REG_FAIL . '<br>' . implode('<br>', $result->getMessages());
                }
            }
        }
        $viewModel = new ViewModel(['loginForm' => $this->loginForm,
                                    'regForm' => $this->regForm,
                                    'message' => $message]);
        $viewModel->setTemplate('login/index/index');
        return $viewModel;
    }
    public function testAction()
    {
    }
}
