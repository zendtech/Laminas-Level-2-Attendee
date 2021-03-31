<?php
namespace Events\Traits;

use Events\Model\EventsTableGatewayInterface;

trait RegistrationModelTrait
{
    protected $regTable;
    public function setRegistrationTable(EventsTableGatewayInterface $table)
    {
        $this->regTable = $table;
    }
}
