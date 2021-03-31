<?php
/**
 * FooDelegator
 */
namespace src\modServices\Delegators;
use Interop\Container\ContainerInterface;
use modServices\Delegators\Foo;
use Laminas\ServiceManager\Factory\FactoryInterface;

class FooDelegatorFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null){
        return new Foo('bar');
    }
}
