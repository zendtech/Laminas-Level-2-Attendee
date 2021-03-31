<?php
namespace App\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Db\TableGateway\TableGateway;

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
