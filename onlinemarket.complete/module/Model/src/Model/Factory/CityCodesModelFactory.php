<?php
namespace Model\Model\Factory;

use Model\Model\CityCodesModel;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class CityCodesModelFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new CityCodesModel(CityCodesModel::TABLE_NAME, $container->get('model-primary-adapter'));
    }
}
