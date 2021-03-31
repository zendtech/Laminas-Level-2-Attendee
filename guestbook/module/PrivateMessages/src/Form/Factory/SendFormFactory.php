<?php
namespace PrivateMessages\Form\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

use PrivateMessages\Form\SendForm as SendForm;

class SendFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $form = new SendForm('send');
        //$form->setBlockCipher($container->get('private-messages-block-cipher'));
        $form->addElements();
        $form->addInputFilter();
        return $form;
    }
}
