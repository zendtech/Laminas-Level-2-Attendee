<?php
/**
 * IndexController
 */
namespace src\modOtherComponents\ListenerAggragates;
class IndexController
{
    public function testAction()
    {
        $em = $this->getEventManager();
        $em->trigger(AppEvent::EVENT_TEST, $this);
    }
}