<?php
namespace SecurePost;

use Registration\Form\RegForm;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\InvokableFactory;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getServiceConfig()
    {
		return [
			'factories' => [
				//** DELEGATORS LAB: Create a new service which returns a "Laminas\Form\Element\Csrf" element
				//** DELEGATORS LAB: define a factory which calls the callback to generate the form, and adds a CSRF form element
			],
			'delegators' => [
				//** DELEGATORS LAB: have the delegator apply to Registration\Form\RegForm
			],
		];
	}
}

