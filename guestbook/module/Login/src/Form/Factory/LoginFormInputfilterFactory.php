<?php
/**
 * LoginFormInputfilterFactory
 */

namespace Login\Form\Factory;
use Interop\Container\ContainerInterface;
use Login\Form\LoginFormInputFilter;
use Zend\ServiceManager\Factory\FactoryInterface;

class LoginFormInputFilterFactory implements FactoryInterface{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new LoginFormInputFilter(
            $container->get('login-locale-list')
        );
    }
}