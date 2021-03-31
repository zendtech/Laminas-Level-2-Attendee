<?php
/**
 * RegisterFormInputFilterFactory
 */

namespace Login\Form\Factory;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class RegisterFormInputFilterFactory implements FactoryInterface {
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new RegisterFormInputFileter(
            $container->get('login-locale-list')
        );
    }
}