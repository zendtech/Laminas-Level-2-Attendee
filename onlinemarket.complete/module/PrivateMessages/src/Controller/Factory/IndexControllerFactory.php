<?php
namespace PrivateMessages\Controller\Factory;
use Model\Entity\UserEntity;
use PrivateMessages\Controller\IndexController;
use PrivateMessages\Form\SendForm as SendForm;
use PrivateMessages\Model\MessagesModel;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        //*** ACL LAB: modify this so that the controller only gets an authenticated user
        $authService = $container->get('login-auth-service');
        $userEntity = $authService->getIdentity() ?? new UserEntity();
        return new IndexController(
            $container->get(MessagesModel::class),
            $container->get(SendForm::class),
            $userEntity
        );
    }
}
