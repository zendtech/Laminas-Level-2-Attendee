<?php
namespace Logging;

use Laminas\Mvc\ {MvcEvent};

//*** LOGGER LAB: add the required "use" statements

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    //*** LOGGER LAB: attach a listener after modules are loaded which sets up the log service as the default exception hander
    public function onBootstrap(MvcEvent $e)
    {
    }

    public function setLogService(MvcEvent $e)
    {
		//*** LOGGER LAB: register the logger as the default error handler
		//*** LOGGER LAB: register the logger as the default exception handler
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'logging-logger' => function ($container) {
                    $logger = new Logger();
                    //*** LOGGER LAB: define a logger which logs everything to the Firefox Console
                    //*** LOGGER LAB: define a logger which logs only critical and above to the PHP error log
                    //*** LOGGER LAB: attach two writers to the same logger
                    return $logger;
                },
            ],
        ];
    }

}
