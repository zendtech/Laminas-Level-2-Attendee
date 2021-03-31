<?php
namespace PrivateMessages\Controller\Factory;
use PrivateMessages\Controller\IndexController;
use PrivateMessages\Form\SendForm as SendForm;
use PrivateMessages\Model\MessagesTable;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new IndexController(
            $container->get(MessagesTable::class),
            $container->get(SendForm::class),
            $container->get('login-auth-service'),
            $container->get('application-session-container')
        );
    }
}
