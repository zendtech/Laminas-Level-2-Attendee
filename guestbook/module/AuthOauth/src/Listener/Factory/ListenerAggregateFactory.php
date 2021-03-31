<?php
namespace AuthOauth\Listener\Factory;

use AuthOauth\Listener\OauthListenerAggregate;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ListenerAggregateFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new OauthListenerAggregate($container, $container->get('auth-oauth-service'));
    }
}
