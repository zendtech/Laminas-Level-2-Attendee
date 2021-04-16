<?php
/**
 * ProfileFieldset
 */
namespace src\modFormsAndHydration\FieldsetsAndForms;
use Laminas\Form\Fieldset;
use Laminas\Hydrator\ {HydratorInterface, ObjectPropertyHydrator};

class UserFieldset extends Fieldset
{
    public function __construct(string $name, array $options, HydratorInterface $hydrator, $entity)
    {
        parent::__construct($name, $options);
        $this->setHydrator($hydrator)->setObject($entity);

        $this->add([
            'name' => 'firstName',
            'options' => [
                'label' => 'First name'
            ]
        ]);

        $this->add([
            'name' => 'lastName',
            'options' => [
                'label' => 'Last name'
            ]
        ]);

        $this->add(new ProfileFieldset(
            ProfileFieldset::TABLE_NAME,
            $options,
            new ObjectPropertyHydrator(),
            new ProfileEntity(),
        ));
    }
}
