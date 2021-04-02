<?php
namespace Market\Controller;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Db\TableGateway\TableGatewayInterface;

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
