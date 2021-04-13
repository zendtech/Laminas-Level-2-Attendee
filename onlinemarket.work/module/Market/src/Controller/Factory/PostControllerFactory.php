<?php
namespace Market\Controller\Factory;

use Model\Table\ {CityCodesTable, ListingsTable};
use Market\Controller\PostController;
use Interop\Container\ContainerInterface;
use Market\Form\PostForm;
use Laminas\ServiceManager\Factory\FactoryInterface;
//*** SESSIONS LAB: add a "use" statement for session container

class PostControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new PostController();
                //*** INITIALIZERS LAB: the following line can be removed once the initializer has been created
        $controller->setListingsTable($container->get(ListingsTable::class));
        $controller->setCityCodesTable($container->get(CityCodesTable::class));
        $controller->setPostForm($container->get(PostForm::class));
                //*** FILE UPLOAD LAB: inject file upload Config into controller
                //*** SESSIONS LAB: inject a session container instance
        //*** EMAIL LAB: inject email Config
        return $controller;
    }
}
