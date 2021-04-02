<?php
namespace PrivateMessages\Model\Factory;
use PrivateMessages\ {Entity\MessageEntity, Model\MessagesModel};
use Interop\Container\ContainerInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;

class MessagesModelFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new MessagesModel(
            new ClassMethodsHydrator(),
            new TableGateway(
                MessagesModel::$tableName,
                $container->get('model-primary-adapter'),
                NULL,
                new HydratingResultSet(
                    new ClassMethodsHydrator(),
                    new MessageEntity()
                )
            )
        );
    }
}