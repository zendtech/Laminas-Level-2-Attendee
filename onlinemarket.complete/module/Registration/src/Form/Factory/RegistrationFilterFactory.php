<?php
namespace Registration\Form\Factory;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Registration\Form\RegistrationFilter;

class RegistrationFilterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new RegistrationFilter(
            $container->get('registration-form-roles'),
            $container->get('registration-form-providers'),
            $container->get('registration-form-locales'));
    }
}
