<?php
/**
 * AbstractActionController
 * Note: This abstract provide the necessary components to run module demos
 * without the full ZF stack
 */
namespace src\core;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Resolver\{AggregateResolver, TemplatePathStack};
use Zend\View\Renderer\PhpRenderer;
use Zend\Form\ConfigProvider;
class AbstractController extends AbstractActionController
{
    protected $renderer;
    function __construct()
    {
        // create a Template Stack
        $stack = new TemplatePathStack([
            'script_paths' => [
                __DIR__
            ]
        ]);

        // create a Resolver
        $resolver = new AggregateResolver();
        $resolver->attach($stack);

        // create a Renderer, add form helper config
        $this->renderer = new PhpRenderer();
        $this->renderer->setResolver($resolver);
        $helperConfig = (new ConfigProvider())->getViewHelperConfig();
        $this->renderer->getHelperPluginManager()->configure($helperConfig);
    }
}