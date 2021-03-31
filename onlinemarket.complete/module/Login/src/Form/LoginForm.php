<?php
namespace Login\Form;
use Zend\Hydrator\HydratorInterface;
use Zend\Form\{
    Form,
    Element\Password,
    Element\Email,
    Element\Submit
};
use Zend\InputFilter\InputFilterInterface;

class LoginForm extends Form
{
    public function __construct(
        $name = null,
        $options = [],
        HydratorInterface $hydrator,
        InputFilterInterface $inputFilter
    ) {
        parent::__construct($name, $options);
        $this->setHydrator($hydrator);
        $this->setInputFilter($inputFilter);

        $this->setAttributes(['method' => 'post']);
        
        $email = new Email('email');
        $email->setLabel('Email Address');        
        $email->setAttributes(['size' => 40]);
        $this->add($email);
        
        $password = new Password('password');
        $password->setLabel('PasswordSecurity');
        $password->setAttributes(['size' => 40]);
        $this->add($password);
        
        $submit = new Submit('submit');
        $submit->setAttributes(['value' => 'Login',
                                'style' => 'color:white;background-color:green;']);
        $this->add($submit);
    }
}
