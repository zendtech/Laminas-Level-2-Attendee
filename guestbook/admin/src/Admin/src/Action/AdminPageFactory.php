<?php
namespace App\Action;

use Interop\Container\ContainerInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Laminas\Db\TableGateway\TableGateway;

class AdminPageFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $router   = $container->get(RouterInterface::class);
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;
        $adapter = $container->get('admin-db-adapter');
        $table = new TableGateway('guestbook', $adapter);
        return new AdminPageAction($router, $template, $table);
    }
}
