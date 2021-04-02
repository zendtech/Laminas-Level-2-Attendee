<?php
namespace Guestbook\Form\Factory;
use Interop\Container\ContainerInterface;
use Laminas\Hydrator\ObjectPropertyHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Guestbook\Form\{GuestbookForm, GuestbookFormFilter};

class GuestbookFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL)
    {
        return new GuestbookForm(new ObjectPropertyHydrator, $container->get(GuestbookFormFilter::class));
    }
}