<?php
namespace Application\Controller;
use PHPUnit\Util\Exception;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $em = $this->getEventManager();
        $em->addIdentifiers(['IDENTIFIER_DB']);
        $em->trigger('EVENT_DB_MOD', $this, ['message' => 'Whatever!!!']);
        return new ViewModel();
    }

    public function exceptionAction()
    {
        //*** LOGGER LAB: Results in an exception thrown as the template is missing.
        return new ViewModel();
    }

    public function triggerAction()
    {
        $this->getEventManager()->trigger('app-event-test', $this, ['message' => 'Surprise!']);
    }

    public function emailAction()
    {
        $sm = $this->getEvent()->getApplication()->getServiceManager();
        $notificationConfig = $sm->get('notification-Config');
        $notificationConfig['to'] = 'test@zend.com';
        $notificationConfig['message'] = sprintf('TEST was successfully posted on %s', date('Y-m-d H:i:s'));
        $em = $this->getEventManager();
        $em->trigger( NotificationEvent::EVENT_NOTIFICATION, 
                      $this, 
                      $notificationConfig );
        return new ViewModel(['success' => NotificationEvent::$success, 'emailDir' => $notificationConfig['transport']['options']['path']]);
    }
}
