<?php
namespace Login\Form\Factory;
use Login\Form\RegisterFormInputFilter;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

use Login\Form\RegisterForm as RegisterForm;

class RegisterFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new RegisterForm(
            new ClassMethodsHydrator(),
            $container->get('login-locale-list'),
            $container->get(RegisterFormInputFilter::class)
        );
    }
}
