<?php
namespace Guestbook\Mapper\Factory;
use Guestbook\Mapper\GuestbookMapper;
use Guestbook\Model\GuestbookModel;
use Interop\Container\ContainerInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\TableGateway\{Feature\EventFeature, TableGateway};
use Laminas\EventManager\EventManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Hydrator\ObjectPropertyHydrator;
class GuestbookMapperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $adapter = $container->get('guestbook-db-adapter');
        $eventManager = new EventManager();
        $eventManager->addIdentifiers([GuestbookMapper::IDENTIFIER]);
        return new GuestbookMapper(
            $adapter,
            $eventManager,
            new TableGateway(
                GuestbookMapper::TABLE_NAME,
                $adapter,
                new EventFeature($eventManager),
                new HydratingResultSet(
                    new ObjectPropertyHydrator,
                    new GuestbookModel()
                )
            )
        );
    }
}
