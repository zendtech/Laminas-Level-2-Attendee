<?php
namespace Market\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\TableGateway\TableGatewayInterface;

class IndexController extends AbstractActionController
{
    protected $listingsModel;
    public function __construct(TableGatewayInterface $listingsModel) {
        $this->listingsModel = $listingsModel;
    }

    public function indexAction()
    {
        return new ViewModel(['item' => $this->listingsModel->findLatest()]);
    }
}
