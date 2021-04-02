<?php
namespace Market\Form\Factory;

use Model\Entity\ListingEntity;
use Market\Form\ {PostForm, PostFilter};
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Hydrator\ObjectPropertyHydrator;

class PostFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PostForm(
            'PostForm',
            $options,
            $container->get('expire-days'),
            $container->get('market-categories'),
            $container->get('captcha-options'),
            $container->get(PostFilter::class),
            new ObjectPropertyHydrator(),
            new ListingEntity()
        );
    }
}
