<?php
namespace guestbook;

use guestbook\V1\Rest\GuestbookApi\GuestbookApiEntity;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Hydrator\ObjectPropertyHydrator;
use Laminas\ApiTools\Provider\ApiToolsProviderInterface;

class Module implements ApiToolsProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return [
            'Laminas\ApiTools\Autoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src',
                ],
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                V1\Rest\GuestbookApi\GuestbookApiAdapter::class => function ($container) {
                    $config  = $container->get('config');
                    $config  = $config['db']['adapter']['guestbook'];
                    return new Adapter($config);
                },
                V1\Rest\GuestbookApi\GuestbookApiTable::class => function ($container) {
                    $adapter = $container->get(V1\Rest\GuestbookApi\GuestbookApiAdapter::class);
                    return new TableGateway(

                },
            ],
        ];
    }
}
