<?php
namespace Api\V1\Rest\ApiService;
use Guestbook\Mapper\GuestbookMapper;
use Interop\Container\ContainerInterface;
class ApiServiceResourceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $mapper = $container->get(GuestbookMapper::class);
        $factory = new HalJsonRendererFactory()
        $service = new ApiServiceResource();
        $service->setMapper($mapper);
        return $service;
    }
}
