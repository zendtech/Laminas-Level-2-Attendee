<?php
/**
 * LoginFormInputFilter
 */

namespace Login\Form;
use Laminas\InputFilter\{InputFilter, Input};
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\InArray;

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