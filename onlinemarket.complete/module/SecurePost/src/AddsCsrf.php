<?php
namespace SecurePost;

use Laminas\Form\Element\Csrf;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;

class AddsCsrf implements DelegatorFactoryInterface
{
	public function __invoke(ContainerInterface $container,
							  $name,
							  callable $callback,
							  array $options = null)
	{
		//** DELEGATORS LAB: run the callback to create the form
		//** DELEGATORS LAB: add the secure form CSRF element to the form
		$form = $callback();
		$form->add(new Csrf('hash'));
		return $form;
	}
}

