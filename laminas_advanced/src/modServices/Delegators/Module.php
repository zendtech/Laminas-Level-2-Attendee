<?php
/**
 * Module
 */
namespace src\modServices\Delegators;
use Zend\Db\Adapter\Adapter;
use Zend\Hydrator\ClassMethodsHydrator;
use ZfcUser\Controller\Factory\RedirectCallbackFactory;
class Module
{
    public function getServiceConfig()
    {
        return [
            'aliases' => [
                'zfcuser_zend_db_adapter' =>  Adapter::class,
            ],
            'invokables' => [
                'zfcuser_register_form_hydrator' => ClassMethodsHydrator::class,
            ],
            'factories' => [
                'zfcuser_redirect_callback' => RedirectCallbackFactory::class,
                SwitchZfcUserHydrator::class => SwitchZfcUserHydratorFactory::class,
            ]
        ];
    }
}