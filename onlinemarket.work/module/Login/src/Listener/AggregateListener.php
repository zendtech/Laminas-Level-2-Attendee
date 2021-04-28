<?php
namespace Login\Listener;

use Model\Entity\UserEntity;
use Laminas\Mvc\MvcEvent;
use Laminas\EventManager\ {AbstractListenerAggregate,EventManagerInterface};

class AggregateListener extends AbstractListenerAggregate
{

    //*** AUTHENTICATION LAB: attach "injectAuthService" as a listener to the MVC dispatch event using a wildcard identifier
    public function attach(EventManagerInterface $eventManager, $priority = 100)
    {
        $shared = $eventManager->getSharedManager();
        $this->listeners[] = '???';
    }
    public function injectAuthService(MvcEvent $e)
    {
        $layout = $e->getViewModel();
        //*** AUTHENTICATION LAB: use service container to retrieve the auth service
        $sm = $e->getApplication()->getServiceManager();
        $authService = '???';
        //*** AUTHENTICATION LAB: inject auth service into layout
        $layout->setVariable('authService', $authService);
    }
}
