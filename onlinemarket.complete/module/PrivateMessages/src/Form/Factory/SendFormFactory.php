<?php
namespace PrivateMessages\Form\Factory;
use PrivateMessages\Form\SendFormInputFilter;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use PrivateMessages\Form\SendForm as SendForm;

class SendFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new SendForm(
            'send',
            $options,
            $container->get(SendFormInputFilter::class),
            new ClassMethodsHydrator()
        );
    }
}