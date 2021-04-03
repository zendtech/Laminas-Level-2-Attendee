<?php
/**
 * DbAdapterAwareTrait
 */
namespace src\modServices\Initializers;
use Zend\Db\Adapter\Adapter;
trait DbAdapterAwareTrait
{
    protected $adapter;
    public function setDbAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }
}