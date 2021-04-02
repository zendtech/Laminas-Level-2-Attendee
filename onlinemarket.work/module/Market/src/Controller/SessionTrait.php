<?php
namespace Market\Controller;

use Laminas\Session\Container;

trait SessionTrait
{
    protected $sessionContainer;
    public function setSessionContainer(Container $sessionContainer)
    {
        $this->sessionContainer = $sessionContainer;
    }
}
