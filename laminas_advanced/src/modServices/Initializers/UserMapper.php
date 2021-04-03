<?php
/**
 * UserMapper
 */
namespace src\modServices\Initializers;
use Zend\Db\Adapter\Adapter;
class UserMapper extends AbstractDbMapper
{
    protected $adapter;
    public function __construct(Adapter $adapter){
        $this->adapter = $adapter;
    }
}