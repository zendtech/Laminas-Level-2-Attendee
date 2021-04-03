<?php
/**
 * Module
 */
namespace src\modOtherComponents\CrossCuttingConcerns;
// use ...
class Module
{
    public function onBootstrap(MvcEvent $event) {
        $container = $event->getApplication()->getServiceManager();
        $eventManager = $event->getApplication()->getEventManager();
    
        // At the end of the routing process we can check if the user is logged in
        // and allowed to enter the requested action
        $eventManager->attach('route', [$this, 'checkUser'], -100);
    }

    public function checkUser(MvcEvent $event) {
        $match = $event->getRouteMatch();
        if (!$match) return;
        $container = $event->getApplication()->getServiceManager();
        $userEntity = $container->get(UserEntity::class);
        if ($match->getParam('needs-user') && !$userEntity->isLoggedIn()) {
            // The user has to be logged in to execute this action
            $match->setParam('controller', 'User');
            $match->setParam('action', 'login');
        }
    }
}