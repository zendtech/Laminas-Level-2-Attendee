<?php
namespace Events\Model\Factory;
use Events\Entity\{
    EventEntity,
    RegistrationEntity,
    AttendeeEntity
};
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;

class TableAbstractFactory implements AbstractFactoryInterface {
    public function canCreate(ContainerInterface $container, $requestedName){
        $can_create = FALSE;
        //*** ABSTRACT FACTORIES LAB: return TRUE for any class that includes Events\Model\*TableModel
        return ($can_create);
    }
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        // example: Events\Model\EventTableModel becomes Events\Entity\EventEntity
        $entity = str_replace(['\Model\\','TableModel'], ['\Entity\\','Entity'], $requestedName);
        //*** ABSTRACT FACTORIES LAB: return the $requestedName with the same arguments using in the ConfigAbstractFactory
        return new $requestedName( /* place arguments here */ );
    }
}
