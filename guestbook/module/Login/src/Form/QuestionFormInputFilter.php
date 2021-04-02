<?php
/**
 * QuestionFormInputFilter
 */

namespace Login\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\EmailAddress;

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