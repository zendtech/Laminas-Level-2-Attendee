<?php
namespace PrivateMessages\Model\Factory;
use PrivateMessages\Model\{MessageModel, MessagesTable};
use Interop\Container\ContainerInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\Factory\FactoryInterface;

class MessagesTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $hydrator = $container->get('private-messages-hydrator');
        return new MessagesTable(
            new TableGateway(
                MessagesTable::$tableName,
                $container->get('login-db-adapter'),
                null,
                new HydratingResultSet($hydrator)
            ),
            $hydrator
        );
    }
}
