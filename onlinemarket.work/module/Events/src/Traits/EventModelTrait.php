<?php
namespace Events\Traits;

use Events\Model\EventsTableGatewayInterface;

trait EventModelTrait
{
    protected $eventTable;
    public function setEventTable(EventsTableGatewayInterface $table)
    {
        $this->eventTable = $table;
    }
}
