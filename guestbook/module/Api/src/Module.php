<?php
namespace Api;

use Laminas\InputFilter\Factory as FilterFactory;
use Laminas\ApiTools\Hal\HalJsonStrategy;
use Laminas\ApiTools\Hal\Factory\HalJsonStrategyFactory;
use Laminas\ApiTools\Provider\ApiToolsProviderInterface;
use Laminas\ServiceManager\Factory\InvokableFactory;

class Module implements ApiToolsProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getServiceConfig()
    {
        return [
            'factories' => [
                HalJsonStrategy::class => function ($container) {
                    return (new HalJsonStrategyFactory())($container);
                },
                ApiInputFilter::class => function ($container) {
                    $mgr = $container->get('InputFilterManager');
                    $factory = new FilterFactory($mgr);
                    $config = $container->get('config')['input_filter_specs'];
                    return $factory->createInputFilter($config['Api\\V1\\Rest\\ApiService\\Validator']);
                },
            ],
        ];
    }
}
