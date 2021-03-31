<?php
//*** INITIALIZERS LAB: this factory will no longer be needed after the initializer has been created
namespace Market\Controller\Factory;
use Market\Controller\ViewController;
use Interop\Container\ContainerInterface;
use Model\Model\ListingsModel;
use Zend\ServiceManager\Factory\FactoryInterface;

class ViewControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        //*** INITIALIZERS LAB: the following line can be removed once the initializer has been created
        return new ViewController($container->get(ListingsModel::class));
    }
}
