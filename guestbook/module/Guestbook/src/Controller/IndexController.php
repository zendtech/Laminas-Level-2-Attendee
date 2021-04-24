<?php
namespace Guestbook\Controller;
use Notification\Event\NotificationEvent;
use Guestbook\Listener\CacheListenerAggregate;
use Guestbook\Model\GuestbookModel;
use Guestbook\Mapper\GuestbookMapper;
use Laminas\View\Model\ {ViewModel, JsonModel};
use Laminas\Form\FormInterface;
use Laminas\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    const SUCCESS_ADD = 'Thanks for signing our guestbook!';
    const ERROR_ADD   = 'SORRY ... unable to add you to the guestbook';
    const ERROR_VALID = 'SORRY ... there was a form validation problem';

    protected $form, $mapper;
    public function __construct(FormInterface $form, GuestbookMapper $mapper){
        $this->form = $form;
        $this->mapper = $mapper;
    }

    public function indexAction()
    {
        $model = $this->mapper->getCount()->current();
        return new ViewModel(['val' => $model->val]);
    }
    public function ajaxAction()
    {
        $data = [];
        $guestList = $this->mapper->findAll();
        foreach ($guestList as $guest) {
            $avatar = '<img src="render.php?fn=' . $guest->avatar . '" width="auto" height="30px" />';
            $data[] = [$guest->name, $avatar, $guest->email, $guest->dateSigned, $guest->message];
        }
        return new JsonModel(['data' => $data]);
    }
    public function signAction()
    {
        $post = $guest = $message = '';
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            $this->form->bind(new GuestbookModel());
            $this->form->setData($post);
            if ($this->form->isValid()) {
                $guest = $this->form->getData();
                $guest->avatar = basename($guest->avatar['tmp_name']);
                if ($this->mapper->add($guest)) {
                    $message = self::SUCCESS_ADD;
                    // trigger event to clear cache
                    $em = $this->getEventManager();
                    $em->trigger(CacheListenerAggregate::EVENT_CLEAR_CACHE, $this, ['entity' => $guest]);
                    // trigger event to send email notification
                    $em->trigger(NotificationEvent::EVENT_EMAIL_NOTIFICATION, $this, ['entity' => $guest]);
                } else {
                    $message = self::ERROR_ADD;
                }
            } else {
                $message = self::ERROR_VALID;
            }
        }
        return new ViewModel(['form' => $this->form, 'message' => $message, 'data' => $post, 'guest' => $guest]);
    }
}
