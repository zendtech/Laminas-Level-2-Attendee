<?php
namespace Events\Model;
use Zend\Db\Adapter\Adapter;
use Events\Entity\EntityInterface;
use Psr\Container\ContainerInterface;

interface TableGatewayInterface
{
    public function __construct(Adapter $adapter,
                                EntityInterface $entity,
                                ContainerInterface $container);
}
