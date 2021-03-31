<?php
namespace Logging;

use Zend\Mvc\ {MvcEvent};

//*** LOGGER LAB: add the required "use" statements
use Zend\Log\Logger;
use Zend\Log\Writer\{Stream, FirePhp};
use Zend\Log\Filter\Priority;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    //*** LOGGER LAB: attach a listener after modules are loaded which sets up the log service as the default exception hander
    public function onBootstrap(MvcEvent $e)
    {
        $em = $e->getApplication()->getEventManager();
        $em->attach(MvcEvent::EVENT_ROUTE, [$this, 'setLogService'], 99);
    }

    public function setLogService(MvcEvent $e)
    {
		//*** LOGGER LAB: register the logger as the default error and exception handler
        $logger = $e->getApplication()->getServiceManager()->get('logging-logger');
        Logger::registerErrorHandler($logger);
        Logger::registerExceptionHandler($logger);
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'logging-logger' => function ($container) {
                    $logger = new Logger();
                    //*** LOGGER LAB: define a logger which logs only critical and above to the PHP error log
                    $writerStream = new Stream($container->get('error-log-filename'));
                    $writerStream->addFilter(new Priority(Logger::ALERT));
                    //*** LOGGER LAB: attach two writers to the same logger, first the stream writer.
                    $logger->addWriter($writerStream);
                    //*** LOGGER LAB: then a Firefox console writer.
                    $logger->addWriter(new FirePhp());
                    return $logger;
                },
            ],
        ];
    }
}
