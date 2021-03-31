<?php
/**
 * QuestionFormInputFilter
 */

namespace Login\Form;
use Zend\InputFilter\InputFilter;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\EmailAddress;

class QuestionFormInputFilter extends InputFilter {
    public function __construct()
    {
        $email = new Input('email');
        $email->getValidatorChain()
            ->attach(new EmailAddress());
        $email->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new StripTags());
        $this->add($email);
    }
}