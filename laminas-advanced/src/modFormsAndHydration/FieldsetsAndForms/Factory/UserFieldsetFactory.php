<?php
/**
 * Factory
 */

namespace src\modFormsAndHydration\FieldsetsAndForms\Factory;
use Interop\Container\ContainerInterface;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;

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