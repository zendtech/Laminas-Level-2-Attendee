<?php
namespace AccessControl\Listener;

use Laminas\Mvc\MvcEvent;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Guestbook\Controller\IndexController;
class AclListenerAggregate implements ListenerAggregateInterface
{

    protected $acl, $authenticationService;

    const DEFAULT_ACTION = 'index';
    const DEFAULT_CONTROLLER = IndexController::class;

    public function __construct($acl, $authenticationService){
        $this->acl = $acl;
        $this->authenticationService = $authenticationService;
    }
    public function attach(EventManagerInterface $eventManager, $priority = 100)
    {
        $shared = $eventManager->getSharedManager();
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH,  [$this, 'checkAcl'], 999);
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH,  [$this, 'injectAcl'], 99);
    }
    public function detach(EventManagerInterface $e, $priority = 100){}
    public function injectAcl(MvcEvent $e)
    {
        $layout = $e->getViewModel();
        $layout->setVariable('acl', $this->acl);
    }
    public function checkAcl(MvcEvent $e)    {
        // pull resource and rights from route match
        $match = $e->getRouteMatch();
        $role = 'guest';
        $rights = $match->getParam('action');
        $resource = $match->getParam('controller');
        // get role
        if ($this->authenticationService->hasIdentity()) {
            $role = $this->authenticationService->getIdentity()->getRole() ?? 'guest';
        }
        // make sure controller which is matched is in the list of resources
        $denied = TRUE;
        if ($this->acl->hasResource($resource)
            && $this->acl->hasRole($role)
            && $this->acl->isAllowed($role, $resource, $rights)) {
                    $denied = FALSE;
        }
        if ($denied && $resource != self::DEFAULT_CONTROLLER) {
            $response = $e->getResponse();
            $response->getHeaders()->addHeaderLine('Location', '/');
            $response->setStatusCode(302);
            return $response;
        }
        // otherwise: do nothing
    }
}
