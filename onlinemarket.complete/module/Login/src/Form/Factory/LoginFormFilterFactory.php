<?php
/**
 * LoginFormFilterFactory
 */

namespace Login\Form\Factory;
use Interop\Container\ContainerInterface;
use Login\Form\LoginFormFilter;
use Laminas\ServiceManager\Factory\FactoryInterface;

class LoginFormFilterFactory implements FactoryInterface{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new LoginFormFilter();
    }
}