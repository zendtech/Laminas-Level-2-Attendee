<?php
namespace Api\V1\Rest\ApiService;
use Guestbook\Mapper\GuestbookMapper;
use Interop\Container\ContainerInterface;
use Laminas\ApiTools\Hal\Factory\HalJsonRendererFactory;
class ApiServiceResourceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $mapper = $container->get(GuestbookMapper::class);
        $service = new ApiServiceResource();
        $service->setMapper($mapper);
        $service->setRenderer(new HalJsonRendererFactory($container));
        return $service;
    }
}
