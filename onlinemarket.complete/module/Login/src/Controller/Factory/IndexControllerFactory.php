<?php
namespace Login\Controller\Factory;
use Login\Controller\IndexController;
use Login\Form\LoginForm as LoginForm;
use Login\Model\UsersModel;
use Interop\Container\ContainerInterface;
use Model\Entity\UserEntity;
use Laminas\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new IndexController(
            $container->get(UsersModel::class),
            $container->get(LoginForm::class),
            $container->get('login-auth-service'),
            $container->get(UserEntity::class)
        );
    }
}
