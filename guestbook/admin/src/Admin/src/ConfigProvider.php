<?php
namespace Admin;

use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\Adapter\AdapterServiceFactory;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    public function getDependencies()
    {
        return [
            'invokables' => [
            ],
            'factories'  => [
                'admin-db-adapter' => AdapterServiceFactory::class,
            ],
        ];
    }

    public function getTemplates()
    {
        return [
            'paths' => [
                'admin'    => [__DIR__ . '/../templates/admin'],
            ],
        ];
    }
}
