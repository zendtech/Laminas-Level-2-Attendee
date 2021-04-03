<?php
/**
 * Module
 */
namespace src\modSecurity\Acl;
use Zend\Mvc\MvcEvent;
class Module
{
    public function onBootstrap($e) {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'checkPermissions'], 100);
    }

    public function checkPermissions(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        $controller = $routeMatch->getParam('controller');
        $action = $routeMatch->getParam('action');
        $rbac = $controller->getCustomRbac();

        if ($rbac->isGranted('admin', $controller)) {
            // ...
        } else {
            // ...
        }
    }
}