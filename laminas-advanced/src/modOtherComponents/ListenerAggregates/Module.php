<?php
/**
 * Module
 */
namespace src\modOtherComponents\ListenerAggregates;
use Laminas\Mvc\MvcEvent;
class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $em = $e->getApplication()->getEventManager();
        $container = $e->getApplication()->getServiceManager();
        $em->attach($container->get(AppEventAggregate::class));
    }
}
