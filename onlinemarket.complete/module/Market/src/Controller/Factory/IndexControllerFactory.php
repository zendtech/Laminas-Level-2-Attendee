<?php
//*** INITIALIZERS LAB: this factory will no longer be needed after the initializer has been created
namespace Market\Controller\Factory;

use Market\Controller\IndexController;
use Interop\Container\ContainerInterface;
use Model\Model\ListingsModel;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        //*** INITIALIZERS LAB: the following line can be removed once the initializer has been created
        //$controller->setListingsTable($container->get(UsersModel::class));
        return new IndexController($container->get(ListingsModel::class));
    }
}
