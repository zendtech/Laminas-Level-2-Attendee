<?php
namespace Model;
use Model\Table\ {CityCodesTable, ListingsTable, UsersTable};
use Model\Hydrator\ListingsHydrator;

return [
    'service_manager' => [
        'services' => [
            'model-primary-adapter-Config' => [
                'driver' => 'PDO',
                'dsn' => 'mysql:hostname=localhost;dbname=zfcourse',
                'username' => 'vagrant',
                'password' => 'vagrant',
            ],
        ],
        'factories' => [
            'model-primary-adapter'   => Adapter\Factory\PrimaryFactory::class,
            ListingsTable::class    => Table\Factory\ListingsTableFactory::class,
            CityCodesTable::class  => Table\Factory\CityCodesTableFactory::class,
            UsersTable::class       => Table\Factory\UsersTableFactory::class,
            //*** DATABASE HYDRATOR LAB: add an entry for factory to produce listings hydrator instance
            ListingsHydrator::class => Hydrator\Factory\ListingsHydratorFactory::class,
        ],
    ],
];
