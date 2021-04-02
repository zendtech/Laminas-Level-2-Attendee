<?php
namespace Model\Model\Factory;
use Model\Entity\UserEntity;
use Model\Model\UsersModel;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Hydrator\ClassMethodsHydrator;

class UsersModelFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new UsersModel(
            $container->get('model-primary-adapter'),
            $container->get(UserEntity::class),
            new ClassMethodsHydrator()
        );
    }
}
