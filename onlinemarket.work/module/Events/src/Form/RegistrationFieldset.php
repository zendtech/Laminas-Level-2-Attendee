<?php
/**
 * RegistrationFieldset
 */
namespace Events\Form;
use Laminas\Form\Fieldset;
use Laminas\Hydrator\HydratorInterface;
class RegistrationFieldset extends Fieldset {
    public function __construct(string $name, HydratorInterface $hydrator, $entity)
    {
        parent::__construct($name, $options);
        $this->setHydrator($hydrator)->setObject($entity);
    }
}