<?php
/**
 * Module
 */
namespace src\modOtherComponents\Session;
use Laminas\Mvc\MvcEvent;
use Laminas\Session\{Config\SessionConfig, Container, SessionManager, Storage\SessionArrayStorage};
class Module
{
    public function getConfig() {
        return [
            'session_config' => [ 'config_class' => SessionConfig::class ],
            'session_storage' => ['type' => SessionArrayStorage::class ],
        ];
    }
    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'startSession'], 9999);
    }
    public function startSession(MvcEvent $e) {
        $serviceContainer = $e->getApplication()->getServiceManager();
        Container::setDefaultManager($serviceContainer->get(SessionManager::class));
    }
}
