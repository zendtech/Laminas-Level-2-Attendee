<?php
namespace Events\Listener;
use Interop\Container\ContainerInterface;
use Zend\EventManager\ {AbstractListenerAggregate,EventManagerInterface,LazyListener};

class AggregateListener extends AbstractListenerAggregate
{
    protected $eventManager, $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    //*** attach "onLog()" as a listener to the modification event using a wildcard identifier
    public function attach(EventManagerInterface $eventManager, $priority = 100)
    {
        $shared = $eventManager->getSharedManager();
        //*** LAZY LISTENER LAB: attach the "onLog()" method as a Lazy Listener
        $lazy = new LazyListener(['listener' => AggregateListener::class, 'method' => 'onLog'], $this->container);
        $this->listeners[] = $shared->attach('*', Event::MOD_EVENT, $lazy);
    }
    public function onLog($e)
    {
        error_log(get_class($e->getTarget()) . ': REGISTRATION ADDED : ' . $e->getParam('registration'));
    }
}
