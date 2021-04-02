<?php
namespace Events\Model\Factory;
use Events\Entity\EventEntity;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;

class TableAbstractFactory implements AbstractFactoryInterface {
    public function canCreate(ContainerInterface $container, $requestedName){
        return fnmatch('*TableModel', $requestedName);
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        return new $requestedName(
            $container->get('events-db-adapter'),
            $container->get(EventEntity::class),
            $container
        );
    }
}