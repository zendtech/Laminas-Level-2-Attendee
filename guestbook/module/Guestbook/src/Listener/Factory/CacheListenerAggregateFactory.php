<?php
namespace Guestbook\Listener\Factory;
use Guestbook\Listener\CacheListenerAggregate;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class CacheListenerAggregateFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new CacheListenerAggregate($container->get('cache-adapter'));
    }
}
