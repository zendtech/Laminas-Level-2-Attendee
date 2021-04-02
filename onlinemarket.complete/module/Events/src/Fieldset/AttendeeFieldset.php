<?php
/**
 * RegistrationFieldset
 */
namespace Events\Fieldset;
use Laminas\Form\Fieldset;
use Laminas\Hydrator\HydratorInterface;
class AttendeeFieldset extends Fieldset {
    public function __construct(string $name, HydratorInterface $hydrator, $entity)
    {
        parent::__construct($name);
        $this->setHydrator($hydrator)->setObject($entity);
    }
}