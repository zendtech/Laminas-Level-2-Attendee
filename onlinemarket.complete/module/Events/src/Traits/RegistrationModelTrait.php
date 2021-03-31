<?php
namespace Events\Traits;

use Events\Model\EventsTableGatewayInterface;

trait RegistrationModelTrait
{
    protected $regTable;
    public function setRegistrationTable($table)
    {
        $this->regTable = $table;
    }
}
