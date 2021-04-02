<?php
namespace Application\Event\Factory;

use Application\Event\Listener\ErrorLog;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ErrorLogFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new ErrorLog($container->get('application-log-dir'), $container->get('application-log-filename'));
    }
}
