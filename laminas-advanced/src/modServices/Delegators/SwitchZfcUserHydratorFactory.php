<?php
/**
 * SwitchZfcUserHydrator
 */
namespace src\modServices\Delegators;
use Interop\Container\ContainerInterface;
use Laminas\Hydrator\ReflectionHydrator;
class SwitchZfcUserHydratorFactory
{
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
        $callback();    // actually don't need to call this!
        return new ReflectionHydrator();
    }
}