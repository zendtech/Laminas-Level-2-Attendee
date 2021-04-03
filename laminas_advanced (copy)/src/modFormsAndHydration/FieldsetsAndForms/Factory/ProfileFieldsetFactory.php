<?php
/**
 * Factory
 */

namespace src\modFormsAndHydration\FieldsetsAndForms\Factory;
use Interop\Container\ContainerInterface;
use src\modFormsAndHydration\FieldsetsAndForms\ProfileFieldset;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Hydrator\ObjectPropertyHydrator;
use modFormsAndHydration\FieldsetsAndForms\ProfileEntity;

class ProfileFieldsetFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ProfileFieldset(
            ProfileFieldset::TABLE_NAME,
            $options,
            new ObjectPropertyHydrator(),
            new ProfileEntity(),
        );
    }
}