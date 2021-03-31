<?php
namespace Events\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel(['serviceManager' => $this->getEvent()->getApplication()->getServiceManager()]);
    }
}
