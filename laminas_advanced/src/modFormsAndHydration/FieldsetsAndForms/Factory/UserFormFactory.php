<?php
/**
 * Factory
 */

namespace src\modFormsAndHydration\FieldsetsAndForms\Factory;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class UserFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new UserForm(
            'create_user',
            $options,
        );
    }
}
