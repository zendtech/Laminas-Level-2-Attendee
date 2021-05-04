<?php
namespace Api\V1\Rest\ApiService;

class ApiServiceResourceFactory
{
    public function __invoke($services)
    {
        return new ApiServiceResource();
    }
}
