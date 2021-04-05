<?php
/**
 * DbAdapterAwareInterface
 */
namespace src\modServices\Initializers;
use Laminas\Db\Adapter\Adapter;

interface DbAdapterAwareInterface
{
    public function setDbAdapter(Adapter $adapter);
}