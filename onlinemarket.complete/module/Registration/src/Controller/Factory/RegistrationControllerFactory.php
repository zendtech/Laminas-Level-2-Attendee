<?php
namespace Registration\Controller\Factory;
use Model\Model\UsersModel;
use Registration\Form\RegistrationForm;
use Registration\Controller\RegistrationController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class RegistrationControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        //*** FORMS LAB: inject the usersModelTableGateway and form classes into the controller
        return new RegistrationController(
            $container->get(UsersModel::class),
            $container->get(RegistrationForm::class)
        );
    }
}
