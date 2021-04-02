<?php
namespace Events\Controller;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Permissions\Acl\AclInterface;
use Laminas\View\Model\ViewModel;

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
