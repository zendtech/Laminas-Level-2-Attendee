<?php
namespace Login\Controller\Factory;
use Login\Controller\IndexController;
use Login\Form\{LoginForm, RegisterForm};
use Login\Model\UsersModel;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new IndexController(
            $container->get(UsersModel::class),
            $container->get(RegisterForm::class),
            $container->get(LoginForm::class),
            $container->get('login-auth-adapter'),
            $container->get('login-auth-service'),
            $container->get('application-session-container'),
            $container->get('application-session-manager')
        );
    }
}