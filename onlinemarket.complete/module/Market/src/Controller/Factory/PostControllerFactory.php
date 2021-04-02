<?php
namespace Market\Controller\Factory;

use Market\Controller\PostController;
use Market\Form\PostForm;
use Interop\Container\ContainerInterface;
use Model\Model\ {
    CityCodesModel,
    ListingsModel
};
use Laminas\ServiceManager\Factory\FactoryInterface;
//*** SESSIONS LAB: add a "use" statement for session container
use Laminas\Session\Container AS SessionContainer;

class PostControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        //*** INITIALIZERS LAB: the following line can be removed once the initializer has been created
        //$controller->setListingsTable($container->get(UsersModel::class));
        return new PostController(
            $container->get(CityCodesModel::class),
            $container->get(PostForm::class),
            $container->get('market-upload-config'),
            $container->get(SessionContainer::class),
            $container->get('notification-Config'),
            $container->get(ListingsModel::class)
        );
    }
}
