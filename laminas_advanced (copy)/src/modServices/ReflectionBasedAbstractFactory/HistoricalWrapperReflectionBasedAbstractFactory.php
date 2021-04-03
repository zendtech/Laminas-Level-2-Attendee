<?php
/**
 * HistoricalWrapperReflectionBasedAbstractFactory
 */
namespace src\modServices\ReflectionBasedAbstractFactory;
use Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
class HistoricalWrapperReflectionBasedAbstractFactory extends ReflectionBasedAbstractFactory
{
    protected $aliases = [
        \Zend\Console\Adapter\AdapterInterface::class     => 'ConsoleAdapter',
        \Zend\Filter\FilterPluginManager::class           => 'FilterManager',
        \Zend\Validator\ValidatorPluginManager::class     => 'ValidatorManager',
    ];
}