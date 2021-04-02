<?php
namespace PrivateMessages\Form;
use Laminas\Hydrator\HydratorInterface;
use Laminas\Form\{
    Form,
    Element\Email,
    Element\Textarea,
    Element\Submit
};
use Laminas\InputFilter\InputFilterInterface;

class SendForm extends Form
{
    public function __construct(
        string $name,
        ?array $options,
        InputFilterInterface $inputFilter,
        HydratorInterface $hydrator
    ) {
        parent::__construct($name, $options);
        $this->setInputFilter($inputFilter);
        $this->setHydrator($hydrator);

        $this->setAttributes(['method' => 'post']);

        $fromEmail = new Email('fromEmail');
        $fromEmail->setLabel('Email Address of Sender');
        $this->add($fromEmail);

        $toEmail = new Email('toEmail');
        $toEmail->setLabel('Email Address of Recipient');
        $this->add($toEmail);

        $password = new Textarea('message');
        $password->setLabel('Message');
        $password->setAttributes(['rows' => 4]);
        $this->add($password);

        $submit = new Submit('submit');
        $submit->setAttributes(['value' => 'Send',
                                'style' => 'color:white;background-color:green;']);
        $this->add($submit);
    }
}
