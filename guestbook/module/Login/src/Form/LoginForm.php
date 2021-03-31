<?php
namespace Login\Form;
use Zend\Hydrator\HydratorInterface;
use Zend\Form\{
    Form,
    Element\Password,
    Element\Email,
    Element\Select,
    Element\Submit
};
use Zend\InputFilter\{InputFilter, Input, InputFilterInterface};

class LoginForm extends Form
{
    public function __construct(
        HydratorInterface $hydrator,
        array $localeList,
        InputFilterInterface $inputFilter)
    {
        parent::__construct(__CLASS__, null);
        $this->setAttributes(['method' => 'post']);
        $this->setHydrator($hydrator);
        $this->addInputFilter($inputFilter);

        $email = (new Email('email'))
            ->setLabel('Email Address')
            ->setAttributes(['size' => 40]);
        $this->add($email);

        $password = (new Password('password'))
            ->setLabel('PasswordSecurity')
            ->setAttributes(['size' => 40]);
        $this->add($password);

        $locale = (new Select('locale'))
            ->setLabel('Preferred Language')
            ->setValueOptions($localeList);
        $this->add($locale);

        $submit = (new Submit('submit'))
            ->setAttributes([
                'value' => 'LoginForm',
                'style' => 'color:white;background-color:green;']
            );
        $this->add($submit);
    }
}
