<?php
namespace Market\Controller;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Form\FormInterface;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\AbstractActionController;
//*** CACHE LAB: add a use statement for the listener aggregate
use Market\Listener\CacheAggregate;
//*** EMAIL LAB: add "use" statement to trigger email notification event
use Notification\Event\NotificationEvent;

class PostController extends AbstractActionController
{
    const ERROR_POST = 'ERROR: unable to validate item information';
    const ERROR_SAVE = 'ERROR: unable to save item to the database';
    const SUCCESS_POST = 'SUCCESS: item posted OK';
    const ERROR_MAX = 'ERROR: invalid form postings';
        const MAX_INVALID = 3;

    protected $listingsModel, $cityCodesModel, $postForm, $uploadConfig, $sessionContainer, $notificationConfig;

    public function __construct(
        TableGatewayInterface $cityCodesModel,
        FormInterface $postForm,
        array $marketUploadConfig,
        $container,
        array $notificationConfig,
        TableGatewayInterface $listingsModel
        ){
        $this->cityCodesModel = $cityCodesModel;
        $this->postForm = $postForm;
        $this->uploadConfig = $marketUploadConfig;
        $this->container = $container;
        $this->notificationConfig = $notificationConfig;
        $this->listingsModel = $listingsModel;
    }

    public function indexAction()
    {
        $data = [];
        if ($this->getRequest()->isPost()) {
            $data = array_merge($this->params()->fromPost(), $this->params()->fromFiles());
            $this->postForm->setData($data);
            if ($this->postForm->isValid()) {

                // retrieve data: due to form binding will get a Model\Entity\Listing instance
                $listing = $this->postForm->getData();
                $listing = $this->processFileUpload($listing);

                // save data and process
                if ($this->listingsModel->save($listing)) {

                    $this->flashMessenger()->addMessage(self::SUCCESS_POST);
                    //*** EMAIL LAB: trigger email notification event
                    $this->notificationConfig['to'] = $listing->contact_email;
                    $this->notificationConfig['message'] = sprintf('%s was successfully posted on %s', $listing->title, date('Y-m-d H:i:s'));
                    $em = $this->getEventManager();
                    $em->trigger( NotificationEvent::EVENT_NOTIFICATION,
                                  $this,
                                  $this->notificationConfig );
                    //*** CACHE LAB: trigger clear cache event
                    $em->trigger(CacheAggregate::EVENT_CLEAR_CACHE, $this);
                    return $this->redirect()->toRoute('market');
                } else {
                    $this->flashMessenger()->addMessage(self::ERROR_SAVE);
                }

            } else {
                //*** SESSIONS LAB: keep track of how many times an invalid form posting is made
                if ($this->redirectIfInvalidPost()) {
                        return $this->redirect()->toRoute('market');
                }
            }
        }

        $viewModel = new ViewModel(['postForm' => $this->postForm, 'data' => $data]);
        $viewModel->setTemplate('market/post/index');
        return $viewModel;
    }

    protected function processFileUpload($listing)
    {
        //*** FILE UPLOAD LAB: move uploaded file from /images folder into /images/<category>
        $tmpFn     = $listing->photo_filename['tmp_name'];
        $tmpDir    = dirname($tmpFn);
        $partialFn = '/' . $listing->category . '/' . basename($tmpFn);
        $finalFn   = str_replace('//', '/', $tmpDir . $partialFn);
        rename($tmpFn, $finalFn);

        //*** FILE UPLOAD LAB: reset $listing->photo_filename'] to final filename /images/<category>/filename
        $listing->photo_filename = str_replace('//', '/', $this->uploadConfig['img_url'] . $partialFn);
        return $listing;
    }

    //*** SESSIONS LAB: keep track of how many times an invalid form posting is made
    //***               if the # times exceeds a limit you set, log a message and redirect home
    protected function redirectIfInvalidPost()
    {
        $redirect = FALSE;
        if (!isset($this->sessionContainer->invalid)) {
            $this->sessionContainer->invalid = 1;
        } else {
            $this->sessionContainer->invalid++;
        }
        $this->flashMessenger()->addMessage(self::ERROR_POST);
        if ($this->sessionContainer->invalid > self::MAX_INVALID) {
            error_log(date('Y-m-d H:i:s') . ': Max invalid form postings reached');
            $this->flashMessenger()->addMessage(self::ERROR_MAX);
            $this->sessionContainer->invalid = 1;
            $redirect = TRUE;
        }
        return $redirect;
    }
}
