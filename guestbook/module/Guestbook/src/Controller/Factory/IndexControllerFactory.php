<?php
namespace Guestbook\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Guestbook\Form\GuestbookForm as GuestbookForm;
use Guestbook\Mapper\GuestbookMapper;
use Guestbook\Controller\IndexController;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new IndexController(
            $container->get(GuestbookForm::class),
            $container->get(GuestbookMapper::class)
        );
    }
}
