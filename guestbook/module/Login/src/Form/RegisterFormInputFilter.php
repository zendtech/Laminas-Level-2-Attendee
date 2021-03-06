<?php
/**
 * RegisterFormInput
 */

namespace Login\Form;
use Laminas\Validator\NotEmpty;
use Laminas\I18n\Validator\Alnum;
use Laminas\Filter\{
    StringTrim,
    StripTags,
};
use Laminas\InputFilter\Input;

class RegisterFormInputFilter extends LoginFormInputFilter {
    public function __construct(array $localList){
        parent::__construct($localList);
        $username = new Input('username');
        $username->getValidatorChain()
            ->attach(new NotEmpty())
            ->attach(new Alnum());
        $username->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new StripTags());
        $this->add($username);

        $question = new Input('securityQuestion');
        $question->getValidatorChain()
            ->attach(new NotEmpty());
        $question->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new StripTags());
        $this->add($question);

        $answer = new Input('securityAnswer');
        $answer->getValidatorChain()
            ->attach(new NotEmpty());
        $answer->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new StripTags());
        $this->add($answer);
    }
}
