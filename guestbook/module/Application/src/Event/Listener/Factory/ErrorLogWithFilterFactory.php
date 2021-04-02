<?php
namespace Application\Event\Factory;

use Application\Event\Filter\MaskCcnum;
use Application\Event\Listener\ErrorLogWithFilter;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ErrorLogWithFilterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new ErrorLogWithFilter(
            $container->get('application-log-dir'),
            $container->get('application-log-filename'),
            $container->get(MaskCcnum::class));
    }
}
