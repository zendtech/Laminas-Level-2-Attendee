<?php
namespace Login\Controller\Factory;

use Login\Controller\IndexController;
use Login\Form\Login as LoginForm;
use Login\Form\Register as RegForm;
use Login\Model\UsersModel;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;


class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $controller = new IndexController();
        $controller->setTable($container->get(UsersModel::class));
        $controller->setLoginForm($container->get(LoginForm::class));
        //*** AUTHENTICATION LAB: need to inject the auth service into the controller
        $controller->setAuthService($container->get('login-auth-service'));
        return $controller;
    }
}
