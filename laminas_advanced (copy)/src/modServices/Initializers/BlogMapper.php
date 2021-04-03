<?php
/**
 * BlogMapper
 */
namespace src\modServices\Initializers;
use Zend\Db\Adapter\Adapter;
class BlogMapper extends AbstractDbMapper
{
    protected $adapter;
    public function __construct(Adapter $adapter){
        $this->adapter = $adapter;
    }
}