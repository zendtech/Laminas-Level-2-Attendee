<?php
/**
 * AppEvent
 */
namespace src\modOtherComponents\ListenerAggregates;
use Laminas\EventManager\Event;
class AppEvent extends Event
{
    const EVENT_TEST = 'application-event-test';
}
