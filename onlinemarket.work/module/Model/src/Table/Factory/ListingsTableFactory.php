<?php
namespace Model\Table\Factory;
use Model\Entity\Listing;
use Model\Table\ListingsTable;
use Model\Hydrator\ListingsHydrator;
use Interop\Container\ContainerInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ListingsTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter = $container->get('model-primary-adapter');
        $entity  = new Listing();
        $hydrator = $container->get(ListingsHydrator::class);
        $resultSet = new HydratingResultSet($hydrator, $entity);
        return new ListingsTable(ListingsTable::TABLE_NAME, $adapter, NULL, $resultSet);
    }
}
