<?php
namespace App\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router;
use Mezzio\Template;
use Mezzio\Plates\PlatesRenderer;
use Mezzio\Twig\TwigRenderer;
use Mezzio\LaminasView\LaminasViewRenderer;
use Laminas\Db\TableGateway\TableGateway;

class AdminPageAction implements ServerMiddlewareInterface
{
    private $table;
    private $router;
    private $template;

    public function __construct(Router\RouterInterface $router, Template\TemplateRendererInterface $template = null, TableGateway $table)
    {
        $this->router   = $router;
        $this->template = $template;
        $this->table    = $table;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        
        if (! $this->template) {
            return new JsonResponse([
                'welcome' => 'Congratulations! You have installed the zend-expressive skeleton application.',
                'docsUrl' => 'https://docs.zendframework.com/zend-expressive/',
            ]);
        }

        $data['routerName'] = 'Zend Router';
        $data['templateName'] = 'Twig';

        return new HtmlResponse($this->template->render('admin::admin-page', $data));
    }
}
