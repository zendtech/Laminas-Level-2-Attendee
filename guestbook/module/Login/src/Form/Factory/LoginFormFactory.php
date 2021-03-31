<?php
namespace Login\Form\Factory;

use Login\Form\LoginFormInputFilter;
use Zend\Hydrator\ClassMethodsHydrator;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Login\Form\LoginForm as LoginForm;

class LoginFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new LoginForm(
            new ClassMethodsHydrator(),
            $container->get('login-locale-list'),
            $container->get(LoginFormInputFilter::class)
        );
    }
}
