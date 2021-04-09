<?php
namespace Login\Listener;

use Model\Entity\UserEntity;
use Laminas\Mvc\MvcEvent;
use Laminas\EventManager\ {AbstractListenerAggregate, EventManagerInterface};

class AggregateListener extends AbstractListenerAggregate
{

    //*** AUTHENTICATION LAB: attach "injectAuthService" as a listener to the MVC dispatch event using a wildcard identifier
    public function attach(EventManagerInterface $eventManager, $priority = 100)
    {
        $shared = $eventManager->getSharedManager();
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH, [$this, 'injectUser'], 88);
    }
    public function injectUser(MvcEvent $e)
    {
        $layout = $e->getViewModel();
        //*** AUTHENTICATION LAB: use service container to retrieve the auth service
        $sm = $e->getApplication()->getServiceManager();
        $authService = $sm->get('login-auth-service');
        //*** AUTHENTICATION LAB: inject user identity into layout
        // get identity
        $identity = $authService->getIdentity() ?? NULL;
        $user = (!empty($identity)) ? $identity : new UserEntity();
        $layout->setVariable('user', $user);
    }
}
