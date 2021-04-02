<?php
namespace RestApi\Controller;
use RestApi\Service\ApiService;
use Laminas\View\Model\JsonModel;
use Laminas\Mvc\Controller\AbstractRestfulController;

class ApiController extends AbstractRestfulController
{
    protected $apiService;

    public function __construct(ApiService $apiService){
        $this->apiService = $apiService;
    }

    public function get($id)
    {
        return new JsonModel($this->apiService->find($id));
    }

    public function getList()
    {
        $params = $this->params()->fromQuery() ?? [];
        if ($params) {
            $result = $this->apiService->search($params);
        } else {
            $result = $this->apiService->find();
        }
        return new JsonModel($result);
    }

    public function update($id, $data)
    {
        return new JsonModel($this->apiService->save($id, $data));
    }

    public function replaceList($data)
    {
        $return = [];
        $result = $this->apiService->add($data);
        if (is_int($result) && $result) {
            $return = ['status' => ApiService::STATUS_OK, 'id' => $result];
        } else {
            $return = ['status' => ApiService::STATUS_NOT_OK, 'message' => $result];
            $this->getResponse()->setStatusCode(500);
        }
        return new JsonModel($return);
    }
}
