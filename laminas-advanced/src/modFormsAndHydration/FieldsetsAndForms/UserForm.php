<?php
/**
 * UserForm
 */
namespace src\modFormsAndHydration\FieldsetsAndForms;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\Form\{Form, Element\Csrf, Element\Submit};
class UserForm extends Form
{
    public function __construct(string $name, array $options = [])
    {
        parent::__construct($name, $options);
        $this->setAttribute('method', 'post');
        $this->add(new UserFieldset(
            'user',
            ['use_as_base_fieldset' => true],
            new ClassMethodsHydrator(),
            new UserEntity()
        ));
        $this->add([
            'type' => Csrf::class,
            'name' => 'csrf'
        ]);
        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Send'
            ],
        ]);
    }
}
