<?php
namespace PrivateMessages\Model\Factory;
use PrivateMessages\ {Entity\MessageEntity, Model\MessagesModel};
use Interop\Container\ContainerInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Hydrator\ClassMethodsHydrator;
use Zend\ServiceManager\Factory\FactoryInterface;

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