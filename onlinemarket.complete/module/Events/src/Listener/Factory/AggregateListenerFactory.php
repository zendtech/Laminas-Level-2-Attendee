<?php
namespace Events\Listener\Factory;

use Events\Listener\AggregateListener;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class AggregateListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new AggregateListener($container);
    }
}
