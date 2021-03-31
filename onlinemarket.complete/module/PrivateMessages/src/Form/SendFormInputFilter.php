<?php
/**
 * SendFormInputFilter
 */

namespace PrivateMessages\Form;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Filter\ {
    StringTrim,
    StripTags
};
use Zend\Validator\ {
    EmailAddress,
    StringLength,
    NotEmpty
};

class SendFormInputFilter extends InputFilter {
    public function __construct(
    ) {

        $toEmail = new Input('toEmail');
        $toEmail->getValidatorChain()
            ->attach(new EmailAddress());
        $toEmail->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new StripTags());
        $this->add($toEmail);

        $fromEmail = new Input('fromEmail');
        $fromEmail->getValidatorChain()
            ->attach(new EmailAddress());
        $fromEmail->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new StripTags());
        $this->add($fromEmail);

        $message = new Input('message');
        $message->getValidatorChain()
            ->attach(new StringLength(['min' => 1, 'max' => 254]))
            ->attach(new NotEmpty());
        $message->getFilterChain()
            ->attach(new StringTrim())
            ->attach(new StripTags());
        $this->add($message);
    }
}