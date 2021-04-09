<?php
namespace AccessControl\Listener;

use AccessControl\Acl\MarketAcl;
use Login\Controller\IndexController;
use Laminas\Authentication\AuthenticationService;
use Laminas\Permissions\Acl\Acl;
use Laminas\Mvc\MvcEvent;
use Laminas\EventManager\ {AbstractListenerAggregate,EventManagerInterface};

class AclListenerAggregate extends AbstractListenerAggregate
{
    protected $acl, $authService;
    const DEFAULT_ACTION     = 'index';
    const DEFAULT_CONTROLLER = IndexController::class;
    const ERROR_NO_AUTH_SVC  = 'ERROR: auth service is missing';
    public function __construct(ACL $acl, AuthenticationService $authService){
        $this->acl = $acl;
        $this->authService = $authService;
    }

    public function attach(EventManagerInterface $e, $priority = 100)
    {
        //*** attach the "checkAcl" and "injectAcl" listeners to the MVC "dispatch" event using the shared manager
        $shared = $e->getSharedManager();
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH,  [$this, 'injectAcl'], 99);
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH,  [$this, 'checkAcl']);
    }
    public function injectAcl(MvcEvent $e)
    {
        $layout = $e->getViewModel();
        $layout->setVariable('acl', $this->acl);
    }
    public function checkAcl(MvcEvent $e)
    {
        // pull resource and rights from route match
        $match = $e->getRouteMatch();
        $rights = $match->getParam('action');
        $resource = $match->getParam('controller');
        // safety checks
        if (empty($this->authService)) {
            throw new Exception(__METHOD__ . ':' . __LINE__ . ':' . self::ERROR_NO_AUTH_SVC);
        }
        // get identity
        $identity = $this->authService->getIdentity() ?? NULL;
        // get role
        $role = (!empty($identity))
              ? $identity->getRole()
              : MarketAcl::DEFAULT_ROLE;
        $denied = TRUE;
        //*** make sure controller which is matched is in the list of resources
        if ($this->acl->hasResource($resource)) {
            if ($this->acl->hasRole($role)) {
                if ($this->acl->isAllowed($role, $resource, $rights)) {
                    $denied = FALSE;
                }
            }
        }
        //*** if denied and we're not already going home ...
        if ($denied && $resource != self::DEFAULT_CONTROLLER) {
            $response = $e->getResponse();
            $response->getHeaders()->addHeaderLine('Location', '/onlinemarket.complete');
            $response->setStatusCode(302);
            return $response;
        }
        // otherwise: do nothing
    }
}
