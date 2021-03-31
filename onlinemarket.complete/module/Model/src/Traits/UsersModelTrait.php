<?php
namespace Model\Traits;
use Application\Model\AbstractTableGateway;
trait UsersModelTrait
{
    protected $usersModelTableGateway;
    public function setUsersModelTableGateway(AbstractTableGateway $usersModelTableGateway)
    {
        $this->usersModelTableGateway = $usersModelTableGateway;
    }
}