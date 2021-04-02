<?php
namespace Registration\Form\Factory;
use Registration\Form\{RegistrationForm, RegistrationFilter};
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class RegistrationFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new RegistrationForm($container->get('registration-form-roles'), $container->get(RegistrationFilter::class));
    }
}
