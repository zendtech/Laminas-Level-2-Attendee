<?php
/**
 * RegistrationFieldset
 */
namespace Events\Form;
use Zend\Form\Fieldset;
use Zend\Hydrator\HydratorInterface;
class AttendeeFieldset extends Fieldset {
    public function __construct(string $name, HydratorInterface $hydrator, $entity)
    {
        parent::__construct($name, $options);
        $this->setHydrator($hydrator)->setObject($entity);
    }
}