<?php
namespace AuthOauth\Listener;

use Exception;
use AuthOauth\Generic\ {AuthServiceTrait, Constants};
use Application\Traits\ServiceManagerTrait;
use Login\Model\UsersModel;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\Authentication\AuthenticationServiceInterface;
use Interop\Container\ContainerInterface;

class OauthListenerAggregate implements ListenerAggregateInterface
{
    use AuthServiceTrait;
    use ServiceManagerTrait;
        
    const EVENT_LOGIN       = 'oauth-event-login';
    const ERROR_NO_EMAIL    = 'ERROR: unable to obtain email address';
    const ERROR_NO_USER     = 'ERROR: unable to lookup user';

    public function __construct(ContainerInterface $container, AuthenticationServiceInterface $authService) {
        $this->setServiceManager($container);
        $this->setAuthService($authService);
    }

    public function attach(EventManagerInterface $eventManager, $priority = 100)
    {
        $shared = $eventManager->getSharedManager();
        $this->listeners[] = $shared->attach('*', self::EVENT_LOGIN, [$this, 'oauthLogin'], 99);
    }
    public function detach(EventManagerInterface $e, $priority = 100)
    {
        // do nothing
    }
    public function oauthLogin($e)
    {
        
        try {
            
            // get email address
            $formUser = $e->getParam('entity', NULL);
            $email = ($formUser) ? $formUser->getEmail() : NULL;
            if (!$email) {
                throw new Exception(__METHOD__ . ':' . self::ERROR_NO_EMAIL);
            }
            
            // Lookup user by email address
            $usersTable = $this->serviceManager->get(UsersModel::class);
            $realUser = $usersTable->findByEmail($email);
            if (!$realUser) {
                throw new Exception(__METHOD__ . ':' . self::ERROR_NO_USER);
            }
            
            // do OAuth authentication if user provider not set to default
            $provider = $realUser->getProvider() ?? Constants::DEFAULT_PROVIDER;
            if ($provider != Constants::DEFAULT_PROVIDER) {
                // pull appropriate oauth adapter
                $oauthAdapter = $this->serviceManager->get('auth-oauth-adapter-' . $realUser->getProvider());
                $result = $oauthAdapter->authenticate($this->authService);
            }
            
        } catch (Exception $e) {

            error_log($e->getFile() . ':' . $e->getLine() . ':' . $e->getMessage());
            header('Location: /');
            exit;

        }
    }
}
