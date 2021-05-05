<?php
namespace Api\V1\Rest\ApiService;

use Guestbook\Model\GuestbookModel;
use Guestbook\Mapper\GuestbookMapper;
use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\ApiTools\Hal\View\HalJsonModel;

class ApiServiceResource extends AbstractResourceListener
{
    /**
     * Injects GuestbookMapper
     *
     * @param GuestbookMapper $mapper
     */
    public $mapper = NULL;
    public function setMapper(GuestbookMapper $mapper)
    {
        $this->mapper = $mapper;
    }
    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        // convert $data into GuestbookModel instance
        $id    = (int) $id;
        $model = $this->mapper->fetchById($id) ?? new GuestbookModel();
        return new HalJsonModel(['status' => 'Success', 'data' => $model]);
    }
    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $result = $this->mapper->fetchAll() ?? [new GuestbookModel()];
        return new HalJsonModel(['status' => 'Success', 'data' => $result]);
    }
    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        // convert $data into GuestbookModel instance
        $model = new GuestbookModel();
        foreach ($data as $key => $value) {
            $model->$key = $value;
        }
        $model->submit = '';  // needed because mapper unsets this property!
        if (!$this->mapper->save($model))
            return new ApiProblem(500, 'Unable to save data');
        } else {
            return new HalJsonModel(['status' => 'Success', 'data' => $model]);
        }
    }
    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

}
