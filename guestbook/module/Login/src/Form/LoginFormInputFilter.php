<?php
/**
 * LoginFormInputFilter
 */

namespace Login\Form;
use Zend\InputFilter\{InputFilter, Input};
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Validator\EmailAddress;
use Zend\Validator\InArray;

class LoginFormInputFilter extends InputFilter{

    public function __construct(array $localList)
    {
        $email = new Input('email');
        $email->getValidatorChain()
            ->attach(new EmailAddress);
        $email->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new StripTags());
        $this->add($email);

        $locale = new Input('locale');
        $locale->getValidatorChain()
            ->attach(new InArray([
                'haystack' => array_keys($localList)
            ]));
        $locale->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new StripTags());
        $this->add($locale);

        $password = new Input('password');
        $password->setRequired(FALSE)
            ->getFilterChain()
            ->attach(new StringTrim());
        $this->add($password);
    }
}