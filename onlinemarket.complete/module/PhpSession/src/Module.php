<?php
namespace PhpSession;
use Zend\Mvc\MvcEvent;
use Zend\Session\{
    Config\SessionConfig,
    SessionManager,
    Container,
    Storage\SessionArrayStorage
};
class Module
{
    public function getConfig()
    {
		return [
            //*** SESSIONS LAB: the "session_config" key is used by Zend\Session\Domain\SessionConfigFactory
			'session_config' => [ 'config_class' => SessionConfig::class ],
            //*** SESSIONS LAB: the "type" key is used by Zend\Session\Domain\SessionStorageFactory
			'session_storage' => ['type' => SessionArrayStorage::class ],
		];
    }
    public function onBootstrap(MvcEvent $e)
    {
        $em = $e->getApplication()->getEventManager();
        //*** SESSIONS LAB: attach a listener which starts the session using the constructed session manager
        $em->attach(MvcEvent::EVENT_DISPATCH, [$this, 'startSession'], 9999);
    }
    public function startSession(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();
		//*** SESSIONS LAB: set this session manager as a default for all session containers
		Container::setDefaultManager($sm->get(SessionManager::class));
    }
    public function getServiceConfig()
    {
        return [
            'factories' => [
                // NOTE: Do not need to define a specific SessionManager factory.  
                //       As long as the Config keys "session_config" and "session_storage" are present,
                //       Zend\Session\Domain\SessionManagerFactory is used
                //       when the service container is asked to return a Zend\Session\SessionManager instance
                Container::class => function($container) {
					return new Container(__NAMESPACE__);
				},
            ],
        ];
    }
}
