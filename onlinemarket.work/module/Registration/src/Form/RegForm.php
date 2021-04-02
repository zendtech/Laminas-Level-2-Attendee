<?php
namespace Registration\Form;

use Laminas\Hydrator\ClassMethods;
use Laminas\InputFilter\InputFilter;
use Laminas\Form\ {Form, Element};
use Laminas\Hydrator\ObjectProperty;

class RegForm extends Form
{

    use ConfigTrait;

    public function __construct($roles, InputFilter $filter)
    {
        parent::__construct('reg-form');
        $this->setRoleConfig($roles);
        $this->addElements();
        $this->setInputFilter($filter);
    }

    public function addElements()
    {
        // pertains to the form itself
        $this->setAttributes(['method' => 'post']);
        $this->setHydrator(new ClassMethods());

        // pertains to form elements
        $email = new Element\Email('email');
        $email->setLabel('Email Address');
        $email->setAttributes(['size' => 40]);
        $this->add($email);

        $password = new Element\Password('password');
        $password->setLabel('Password');
        $password->setAttributes(['size' => 40]);
        $this->add($password);

        $name = new Element\Text('username');
        $name->setLabel('User Name');
        $name->setAttributes(['size' => 40]);
        $this->add($name);

        $question = new Element\Text('securityQuestion');
        $question->setLabel('Security Question');
        $question->setAttributes(['size' => 40]);
        $this->add($question);

        $answer = new Element\Text('securityAnswer');
        $answer->setLabel('Security Answer');
        $answer->setAttributes(['size' => 40]);
        $this->add($answer);

        $role = new Element\Radio('role');
        $role->setLabel('Role');
        $role->setValueOptions($this->roleConfig);
        $this->add($role);

        $submit = new Element\Submit('submit');
        $submit->setAttributes(['value' => 'Register',
                                'style' => 'color:white;background-color:green;']);
        $this->add($submit);
    }
}
