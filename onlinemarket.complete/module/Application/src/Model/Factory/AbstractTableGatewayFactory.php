<?php
/**
 * AbstractTableGatewayFactory
 */
namespace Application\Model\Factory;
use Interop\Container\ContainerInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Hydrator\ClassMethodsHydrator;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Stdlib\ArrayObject;

class AbstractTableGatewayFactory  implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new AbstractTableGateway(
            new TableGateway(
                static::$tableName,
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