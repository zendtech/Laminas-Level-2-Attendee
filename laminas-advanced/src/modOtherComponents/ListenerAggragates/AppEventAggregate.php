<?php
/**
 * AppEventAggregate
 */
namespace src\modOtherComponents\ListenerAggragates;
use Laminas\EventManager\{EventManagerInterface, ListenerAggregateInterface};
use Laminas\Mvc\MvcEvent;
class AppEventAggregate implements ListenerAggregateInterface
{
    protected $listeners = [];
    public function attach(EventManagerInterface $eventManager, $priority = 100) {
        $sharedEM = $eventManager->getSharedManager();
        $this->listeners[] = $sharedEM->attach('*', AppEvent::EVENT_TEST, [$this, 'someListener'], $priority);
        $this->listeners[] = $sharedEM->attach(MvcEvent::EVENT_DISPATCH, 'interested Party', [$this, 'someOtherListener'], $priority);
    }

    public function detach(EventManagerInterface $eventManager) {
        foreach ($this->listeners as $key => $listener) {
            if ($listener instanceof ListenerAggregateInterface) {
                $listener->detach($eventManager);
                unset($this->listeners[$key]);
                continue;
            }
            $eventManager->detach($listener);
            unset($this->listeners[$key]);
        }
    }

    public function someListener(MvcEvent $e) {
        $whoTriggered = get_class($e->getTarget());
        $optMessage   = $e->getParam('message') ?? 'No Message';
        error_log(__METHOD__ . ':' . $whoTriggered . ':' . $optMessage);
    }
}