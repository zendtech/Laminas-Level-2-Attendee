<?php
namespace Market\Controller;

use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController implements ListingsTableAwareInterface
{
    use ListingsTableTrait;
    public function __construct(TableGatewayInterface $tableGateway){
        $this->listingsTable = $tableGateway;
    }
    public function indexAction()
    {
        $item = $this->listingsTable->findLatest();
        return new ViewModel(['item' => $item]);
    }
}
