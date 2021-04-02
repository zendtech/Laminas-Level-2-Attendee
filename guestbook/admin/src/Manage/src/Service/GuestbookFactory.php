<?php
namespace Manage\Service;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\TableGateway\TableGateway;
use Interop\Container\ContainerInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;

class GuestbookFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $service = new Guestbook();
        $adapter = new Adapter($container->get('db-config'));
        $table   = new TableGateway('guestbook', $adapter);
        $service->setTable($table);
        return $service;
    }
}
