<?php
/**
 * DbAdapterAwareInterface
 */
namespace src\modServices\Initializers;
use Zend\Db\Adapter\Adapter;

interface DbAdapterAwareInterface
{
    public function setDbAdapter(Adapter $adapter);
}