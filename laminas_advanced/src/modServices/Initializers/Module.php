<?php
/**
 * Module
 */
namespace src\modServices\Initializers;
use Interop\Container\ContainerInterface;
class Module
{
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'blog-mapper' =>
                    function (ContainerInterface $container, $reqName, array $options = null) {
                        return new BlogMapper($container->get('db-adapter'));
                    },
                'comment-mapper' =>
                    function (ContainerInterface $container, $reqName, array $options = null) {
                        return new CommentMapper($container->get('db-adapter'));
                    },
                'user-mapper' =>
                    function (ContainerInterface $container, $reqName, array $options = null) {
                        return new UserMapper($container->get('db-adapter'));
                    },
            ]
        ];
    }
}