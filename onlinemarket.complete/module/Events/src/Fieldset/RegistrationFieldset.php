<?php
/**
 * RegistrationFieldset
 */
namespace Events\Fieldset;
use Zend\Form\Fieldset;
use Zend\Hydrator\HydratorInterface;
class RegistrationFieldset extends Fieldset {
    public function __construct(string $name, HydratorInterface $hydrator, $entity)
    {
        parent::__construct($name);
        $this->setHydrator($hydrator)->setObject($entity);
    }
}