<?php
namespace Events\Controller;
use Laminas\Authentication\AuthenticationService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Permissions\Acl\AclInterface;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    //*** ACL LAB: need to inject the ACL into the controller
    //*** AUTH LAB: need to inject the auth service into the controller
    /*
    protected $acl, $authService;
    public function __construct(AclInterface $acl, AuthenticationService $authService)
    {
        //*** code goes here
    }
    */
    public function indexAction()
    {
        //*** ACL LAB: send the ACL to the view
        //*** AUTH LAB: send the auth service to the view
        return new ViewModel();
    }
}
