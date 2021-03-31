<?php
namespace Events\Controller;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Permissions\Acl\AclInterface;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    protected $acl;
    protected $authService;
	public function __construct(
	    $acl = null,
        $authService
    ){
	    $this->acl = $acl;
	    $this->authService = $authService;
    }
    public function indexAction()
    {
        return new ViewModel(['acl' => $this->acl, 'authenticationService' => $this->authService]);
    }
}
