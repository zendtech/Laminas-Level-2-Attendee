<?php
/**
 * IndexController
 */
namespace src\modOtherComponents\ListenerAggregates;
class IndexController
{
    public function testAction()
    {
        $em = $this->getEventManager();
        $em->trigger(AppEvent::EVENT_TEST, $this);
    }
}
