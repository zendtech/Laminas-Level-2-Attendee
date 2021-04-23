<?php
namespace Market\Listener\Factory;

use Market\Listener\CacheAggregate;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class CacheAggregateFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        //*** CACHE LAB: create a CacheAggregate instance and inject the cache adapter
        $aggregate = new CacheAggregate();
        return $aggregate;
    }
}
