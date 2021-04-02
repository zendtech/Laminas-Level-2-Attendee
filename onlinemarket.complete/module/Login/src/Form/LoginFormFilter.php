<?php
/**
 * LoginFormFilter
 */

namespace Login\Form;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\Input;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\NotEmpty;

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