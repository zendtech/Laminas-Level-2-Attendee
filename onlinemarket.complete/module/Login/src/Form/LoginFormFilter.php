<?php
/**
 * LoginFormFilter
 */

namespace Login\Form;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\EmailAddress;
use Zend\Validator\NotEmpty;

class LoginFormFilter extends InputFilter {
    public function __construct() {
        $email = new Input('email');
        $email->getValidatorChain()
            ->attach(new EmailAddress());
        $email->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new StripTags());
        $this->add($email);

        $password = new Input('password');
        $password->getValidatorChain()
            ->attach(new NotEmpty());
        $this->add($password);
    }
}