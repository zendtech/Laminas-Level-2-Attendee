<?php
namespace Registration\Form;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\InputFilter\InputFilter;
use Laminas\Form\ {
    Form,
    Element\Email,
    Element\Password,
    Element\Text,
    Element\Radio,
    Element\Submit
};
class RegistrationForm extends Form
{
    use ConfigTrait;
    public function __construct($roles, InputFilter $filter)
    {
        parent::__construct('registration-form');
        $this->setRoleConfig($roles);
        $this->setInputFilter($filter);

        // pertains to the form itself
        $this->setAttributes(['method' => 'post']);
        $this->setHydrator(new ClassMethodsHydrator());

        // pertains to form elements
        $email = new Email('email');
        $email->setLabel('Email Address');
        $email->setAttributes(['size' => 40]);
        $this->add($email);

        $password = new Password('password');
        $password->setLabel('PasswordSecurity');
        $password->setAttributes(['size' => 40]);
        $this->add($password);

        $name = new Text('username');
        $name->setLabel('User Name');
        $name->setAttributes(['size' => 40]);
        $this->add($name);

        $question = new Text('securityQuestion');
        $question->setLabel('Security Question');
        $question->setAttributes(['size' => 40]);
        $this->add($question);

        $answer = new Text('securityAnswer');
        $answer->setLabel('Security Answer');
        $answer->setAttributes(['size' => 40]);
        $this->add($answer);

        $role = new Radio('role');
        $role->setLabel('Role');
        $role->setValueOptions($this->roleConfig);
        $this->add($role);

        $submit = new Submit('submit');
        $submit->setAttributes(['value' => 'Register',
                                'style' => 'color:white;background-color:green;']);
        $this->add($submit);
    }
}
