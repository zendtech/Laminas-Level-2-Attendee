<?php
/**
 * AppEvent
 */
namespace src\modOtherComponents\ListenerAggragates;
use Zend\EventManager\Event;
class AppEvent extends Event
{
    const EVENT_TEST = 'application-event-test';
}