<?php
namespace Application\Traits;

use Laminas\Session\ManagerInterface;
use Laminas\Session\Container as SessionContainer;

trait SessionTrait
{
    protected $sessionContainer;
    protected $sessionManager;
    public function setSessionContainer(SessionContainer $item)
    {
        $this->sessionContainer = $item;
    }
    public function setSessionManager(ManagerInterface $item)
    {
        $this->sessionManager = $item;
    }
}
