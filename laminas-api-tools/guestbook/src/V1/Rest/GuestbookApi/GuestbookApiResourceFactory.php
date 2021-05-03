<?php
namespace guestbook\V1\Rest\GuestbookApi;

use guestbook\V1\Rest\GuestbookApi\ {
    GuestbookApiEntity,
    GuestbookApiResource,
    GuestbookApiTable
};

use Laminas\ApiTools\DbConnectedResource;
use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;

class GuestbookApiResourceFactory
{
    public function __invoke($container)
    {
        $table         = $container->get(GuestbookApiTable::class);
        $identifier    = 'id';
        $collection    = GuestbookApiEntity::class;
        return new GuestbookApiResource(($table, $identifier, $collection);
    }
}
