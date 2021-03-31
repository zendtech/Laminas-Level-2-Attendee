<?php
namespace Events\Traits;

use Events\Model\EventsTableGatewayInterface;

trait EventModelTrait
{
    protected $eventTable;
    public function setEventTable($table)
    {
        $this->eventTable = $table;
    }
}
