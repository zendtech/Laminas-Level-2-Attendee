<?php
namespace Model\Model\Factory;
use Model\Entity\ListingEntity;
use Model\Hydrator\ListingsHydrator;
use Model\Model\ListingsModel;
use Interop\Container\ContainerInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\ServiceManager\Factory\FactoryInterface;

class ListingsModelFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter = $container->get('model-primary-adapter');
        return new ListingsModel(
            ListingsModel::TABLE_NAME,
            $adapter,
            NULL,
            new HydratingResultSet(
                $container->get(ListingsHydrator::class),
                $container->get(ListingEntity::class)
            )
        );
    }
}