<?php
namespace Market\Form\Delegator\Factory;
use Market\Form\Delegator\FormDelegator;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\DelegatorFactoryInterface;

class FormDelegatorFactory implements DelegatorFactoryInterface
{
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
        return (new FormDelegator(call_user_func($callback)))->getForm();
    }
}