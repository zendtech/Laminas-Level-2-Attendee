<?php
/**
 * AbstractDbMapper
 */
namespace src\modServices\Initializers;
use Zend\Db\Adapter\Adapter;
abstract class AbstractDbMapper
{
    protected $adapter;
    public function setDbAdapter(Adapter $adapter) {
        $this->adapter = $adapter;
    }
}