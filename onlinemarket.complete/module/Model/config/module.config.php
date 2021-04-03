<?php
namespace Model;
use Model\Entity\ListingEntity;
use Model\Entity\UserEntity;
use Model\Model\Factory\ListingsModelFactory;
use Model\Model\{CityCodesModel,
    Factory\CityCodesModelFactory,
    Factory\UsersModelFactory,
    ListingsModel,
    UsersModel};
use Model\Adapter\{
    Factory\PrimaryAdapterFactory,

};
use Model\Hydrator\ListingsHydrator;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'services' => [
            'model-primary-adapter-Config' => [
                'driver' => 'PDO',
                'dsn' => 'mysql:hostname=localhost;dbname=zfcourse',
                'username' => 'laminas',
                'password' => 'password',
            ],
        ],
        'factories' => [
            'model-primary-adapter' => PrimaryAdapterFactory::class,
            ListingsModel::class => ListingsModelFactory::class,
            CityCodesModel::class => CityCodesModelFactory::class,
            UsersModel::class => UsersModelFactory::class,
            //*** DATABASE HYDRATOR LAB: add an entry for factory to produce listings hydrator instance
            ListingsHydrator::class => InvokableFactory::class,
            ListingEntity::class => InvokableFactory::class,
            UserEntity::class => InvokableFactory::class
        ],
    ],
];
