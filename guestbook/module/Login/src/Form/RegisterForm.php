<?php
namespace Login\Form;
use Zend\Form\{
    Element\Text,
};
use Zend\Hydrator\HydratorInterface;
use Zend\InputFilter\InputFilterInterface;

class RegisterForm extends LoginForm
{
    public function __construct(
        HydratorInterface $hydrator,
        array $localList,
        InputFilterInterface $inputFilter
    ){
        parent::__construct($hydrator, $localList, $inputFilter);

        $name = (new Text('username'))
            ->setLabel('User Name')
            ->setAttributes(['size' => 40]);
        $this->add($name);
        
        $question = (new Text('securityQuestion'))
            ->setLabel('Security Question')
            ->setAttributes(['size' => 40]);
        $this->add($question);
        
        $answer = (new Text('securityAnswer'))
            ->setLabel('Security Answer')
            ->setAttributes(['size' => 40]);
        $this->add($answer);
        
        $submit = $this->get('submit');
        $submit->setAttributes([
            'value' => 'RegisterForm',
            'style' => 'color:white; background-color:green;'
        ]);
    }
}
