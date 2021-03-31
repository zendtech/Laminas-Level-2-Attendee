<?php
namespace PhpSession;

use Zend\Mvc\MvcEvent;
//*** SESSIONS LAB: add the appropriate "use" statements

class Module
{
    public function getConfig()
    {
		return [
            //*** SESSIONS LAB: the "session_config" key is used by Zend\Session\Service\SessionConfigFactory
            //*** SESSIONS LAB: enter the type of Config to use
            //*** SESSIONS LAB: the "type" key is used by Zend\Session\Service\SessionStorageFactory
            //*** SESSIONS LAB: enter the type of storage to use
		];
    }
    public function onBootstrap(MvcEvent $e)
    {
        $em = $e->getApplication()->getEventManager();
        //*** SESSIONS LAB: attach a listener which starts the session using the constructed session manager
    }
    public function startSession(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();
		//*** SESSIONS LAB: set this session manager as a default for all session containers
    }
    public function getServiceConfig()
    {
        return [
            'factories' => [
                // NOTE: Do not need to define a specific SessionManager factory.  
                //       As long as the Config keys "session_config" and "session_storage" are present,
                //       Zend\Session\Service\SessionManagerFactory is used
                //       when the service container is asked to return a Zend\Session\SessionManager instance
                Container::class => function($container) {
					return new Container(__NAMESPACE__);
				},
            ],
        ];
    }
}
