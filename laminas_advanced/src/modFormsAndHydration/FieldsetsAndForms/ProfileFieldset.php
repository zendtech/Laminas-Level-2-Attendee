<?php
/**
 * ProfileFieldset
 */
namespace src\modFormsAndHydration\FieldsetsAndForms;
use Zend\Form\Fieldset;
use Zend\Hydrator\HydratorInterface;

class ProfileFieldset extends Fieldset
{
    public const TABLE_NAME = 'profile';
    public function __construct(string $name, array $options, HydratorInterface $hydrator, $entity)
    {
        parent::__construct($name, $options);
        $this->setHydrator($hydrator)
                ->setObject($entity);
        $this->add([
            'name' => 'company',
            'options' => [
                'label' => 'Company'
            ]
        ]);
        $this->add([
            'name' => 'location',
            'options' => [
                'label' => 'Location'
            ]
        ]);
    }
}