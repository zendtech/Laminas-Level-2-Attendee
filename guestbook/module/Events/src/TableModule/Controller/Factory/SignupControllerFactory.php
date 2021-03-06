<?php
namespace Events\TableModule\Controller\Factory;
use Events\TableModule\Controller\SignupController;
use Events\TableModule\Model\ {EventModel,RegistrationModel, AttendeeModel};
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class SignupControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new SignupController(
            $container->get(EventModel::class),
            $container->get(RegistrationModel::class),
            $container->get(AttendeeModel::class),
            $container->get('events-reg-data-filter')
        );
    }
}
