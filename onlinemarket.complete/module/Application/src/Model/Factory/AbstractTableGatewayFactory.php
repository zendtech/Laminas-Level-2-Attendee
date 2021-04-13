<?php
/**
 * AbstractTableGatewayFactory
 */
namespace Application\Model\Factory;
use Interop\Container\ContainerInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Stdlib\ArrayObject;

class AbstractTableGatewayFactory  implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new $requestedName(
            new TableGateway(
                $requestedName::TABLE_NAME,
                $container->get('model-primary-adapter'),
                null,
                new HydratingResultSet(
                    new ClassMethodsHydrator(),
                    new ArrayObject()
                )
            )
        );
    }
}
