<?php
/**
 * AppEvent
 */
namespace src\modOtherComponents\ListenerAggragates;
use Laminas\EventManager\Event;
class AppEvent extends Event
{
    const EVENT_TEST = 'application-event-test';
}