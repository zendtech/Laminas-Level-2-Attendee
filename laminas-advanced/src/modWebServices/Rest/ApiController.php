<?php
/**
 * IndexController
 */
namespace src\modWebServices\Rest;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\{FeedModel, JsonModel, ViewModel};
class ApiController extends AbstractActionController
{
    protected $criteria = [
        ViewModel::class => ['text/html', 'application/xhtml+xml'],
        JsonModel::class => ['application/json', 'application/javascript'],
        FeedModel::class => ['application/rss+xml', 'application/atom+xml']
    ];
    public function putAction()
    {
        $model = $this->acceptableViewModelSelector($this->criteria);
        $vars = ['var1', 'var2'];
        $model->setVariables($vars);
        return $model;
    }
}