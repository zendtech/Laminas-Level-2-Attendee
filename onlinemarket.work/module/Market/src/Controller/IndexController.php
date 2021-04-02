<?php
namespace Market\Controller;

use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

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
