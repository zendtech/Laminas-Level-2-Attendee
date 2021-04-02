<?php
namespace Login\Form\Factory;

use Login\Form\LoginFormFilter;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Login\Form\LoginForm;

class LoginFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new LoginForm(
            'login',
            $options,
            new ClassMethodsHydrator(),
            new LoginFormFilter()
        );
    }
}
