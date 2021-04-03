<?php
namespace PrivateMessages\Form;

use Laminas\Filter;
use Laminas\Validator;
use Laminas\Form\Element;
use Laminas\Form\Form;
use Laminas\InputFilter\ {InputFilter, Input};
use Laminas\Hydrator\ClassMethods;

class Send extends Form
{
    public function addElements()
    {
        $this->setHydrator(new ClassMethods());
        $this->setAttributes(['method' => 'post']);

        $fromEmail = new Element\Email('fromEmail');
        $fromEmail->setLabel('Email Address of Sender');
        $this->add($fromEmail);

        $toEmail = new Element\Email('toEmail');
        $toEmail->setLabel('Email Address of Recipient');
        $this->add($toEmail);

        $password = new Element\Textarea('message');
        $password->setLabel('Message');
        $password->setAttributes(['rows' => 4]);
        $this->add($password);

        $submit = new Element\Submit('submit');
        $submit->setAttributes(['value' => 'Send',
                                'style' => 'color:white;background-color:green;']);
        $this->add($submit);
    }

    public function addInputFilter()
    {
        $inputFilter = new InputFilter();

        $toEmail = new Input('toEmail');
        $toEmail->getValidatorChain()
              ->attach(new Validator\EmailAddress());
        $toEmail->getFilterChain()
              ->attach(new Filter\StringTrim())
              ->attach(new Filter\StripTags());
        $inputFilter->add($toEmail);

        $fromEmail = new Input('fromEmail');
        $fromEmail->getValidatorChain()
              ->attach(new Validator\EmailAddress());
        $fromEmail->getFilterChain()
              ->attach(new Filter\StringTrim())
              ->attach(new Filter\StripTags());
        $inputFilter->add($fromEmail);

        $message = new Input('message');
        $message->getValidatorChain()
              ->attach(new Validator\StringLength(['min' => 1, 'max' => 254]))
              ->attach(new Validator\NotEmpty());
        $message->getFilterChain()
              ->attach(new Filter\StringTrim())
              ->attach(new Filter\StripTags());
        $inputFilter->add($message);


        $this->setInputFilter($inputFilter);
        return $inputFilter;
    }
}
