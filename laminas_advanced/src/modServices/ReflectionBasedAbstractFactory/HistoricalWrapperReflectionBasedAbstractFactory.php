<?php
/**
 * HistoricalWrapperReflectionBasedAbstractFactory
 */
namespace src\modServices\ReflectionBasedAbstractFactory;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
class HistoricalWrapperReflectionBasedAbstractFactory extends ReflectionBasedAbstractFactory
{
    protected $aliases = [
        \Laminas\Console\Adapter\AdapterInterface::class     => 'ConsoleAdapter',
        \Laminas\Filter\FilterPluginManager::class           => 'FilterManager',
        \Laminas\Validator\ValidatorPluginManager::class     => 'ValidatorManager',
    ];
}
