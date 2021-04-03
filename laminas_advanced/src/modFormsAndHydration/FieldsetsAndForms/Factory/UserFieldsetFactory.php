<?php
/**
 * Factory
 */

namespace src\modFormsAndHydration\FieldsetsAndForms\Factory;
use Interop\Container\ContainerInterface;
use Zend\Hydrator\ClassMethodsHydrator;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserFieldsetFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new UserFieldset(
            'user',
            $options,
            new ClassMethodsHydrator(),
            new UserEntity(),
        );
    }
}