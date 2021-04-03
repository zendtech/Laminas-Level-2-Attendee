<?php
/**
 * AclListenerAggregate
 */
namespace src\modSecurity\Acl\UseCase;
use Zend\EventManager\{EventManagerInterface, ListenerAggregateInterface};
use Zend\Mvc\MvcEvent;
class AclListenerAggregate implements ListenerAggregateInterface
{
    protected $listeners = [];
    public function attach(EventManagerInterface $eventManager, $priority = 100) {
        $shared = $eventManager->getSharedManager();
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH,  [$this, 'injectAcl'], 99);
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH,  [$this, 'checkAcl'], 999);
    }
    public function injectAcl(MvcEvent $e) {
        $sm = $this->getServiceManager();
        $acl = $sm->get('access-control-guestbook-acl');
        $layout = $e->getViewModel();
        $layout->setVariable('acl', $acl);
    }
    public function checkAcl(MvcEvent $e) {
        // get ACL and auth service
        $sm = $this->getServiceManager();
        $acl = $sm->get('access-control-guestbook-acl');
        $authService = $sm->get('login-auth-service');
        // pull resource and rights from route match
        $match = $e->getRouteMatch();
        $rights = $match->getParam('action');
        $resource = $match->getParam('controller');
        // get role
        $role = ($authService->hasIdentity())
            ? $authService->getIdentity()->getRole()
            : 'guest';
        // make sure controller which is matched is in the list of resources
        $denied = TRUE;
        if ($acl->hasResource($resource)
            && $acl->hasRole($role)
            && $acl->isAllowed($role, $resource, $rights)) {
            $denied = FALSE;
        }
        if ($denied && $resource != Module::DEFAULT_CONTROLLER) {
            $match->setParam('controller', Module::DEFAULT_CONTROLLER);
            $match->setParam('action', Module::DEFAULT_ACTION);
        }
        // otherwise: do nothing
    }

    public function detach(EventManagerInterface $events) {}
}