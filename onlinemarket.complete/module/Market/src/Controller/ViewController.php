<?php
namespace Market\Controller;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ViewController extends AbstractActionController
{
    protected $listingsModel;

    public function __construct(TableGatewayInterface $listingsModel) {
        $this->listingsModel = $listingsModel;
    }

    public function indexAction()
    {
        $category = $this->params()->fromRoute('category');
        $list = $this->listingsModel->findByCategory($category);
        return new ViewModel(['category' => $category, 'listing' => $list]);
    }
    public function itemAction()
    {
        $itemId = $this->params()->fromRoute('itemId');
        $item = $this->listingsModel->findById($itemId);
        return new ViewModel(['item' => $item]);
    }
}
