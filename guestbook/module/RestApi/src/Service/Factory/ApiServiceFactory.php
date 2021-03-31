<?php
namespace RestApi\Service\Factory;
use RestApi\Service\ApiService;
use Events\TableModule\Model\ {EventModel, RegistrationModel, AttendeeModel};
use Interop\Container\ContainerInterface;
use Zend\Db\Sql\ {Sql, Where};
use Zend\ServiceManager\Factory\FactoryInterface;
class ApiServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new ApiService(
            $container->get(EventModel::class),
            $container->get(RegistrationModel::class),
            $container->get(AttendeeModel::class),
            new Sql($container->get('events-db-adapter')),
            new Where()
        );
    }
}