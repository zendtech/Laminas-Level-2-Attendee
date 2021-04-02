<?php
namespace Guestbook\Form;
use Laminas\Form\{
    Form,
    Element\Text,
    Element\Email,
    Element\Url,
    Element\Textarea,
    Element\File,
    Element\Submit
};
use Laminas\InputFilter\{InputFilterInterface};
use Laminas\Hydrator\HydratorInterface;
class GuestbookForm extends Form
{
    public function __construct(
        HydratorInterface $hydrator,
        InputFilterInterface $inputFilter,
        array $options = null)
    {
        parent::__construct(__CLASS__, $options);
        $this->setHydrator($hydrator);
        $this->setInputFilter($inputFilter);

        // set form tag attribs
        $this->setAttributes([
            'method' => 'post',
            'enctype' => 'multipart/form-data']
        );

        // assign elements
        $name = (new Text('name'))->setLabel('Name');
        $this->add($name);

        $email = (new Email('email'))->setLabel('Email Address');
        $this->add($email);

        $website = (new Url('website'))->setLabel('Website');
        $this->add($website);

        $message = (new Textarea('message'))
            ->setLabel('Comments')
            ->setAttributes(['rows' => 4, 'cols' => 80]);
        $this->add($message);

        $file = (new File('avatar'))->setLabel('Avatar Image Upload');
        $this->add($file);

        $submit = (new Submit('submit'))
            ->setAttributes([
                'value' => 'Sign GuestbookForm',
                'style' => 'color:white;background-color:green;'
            ]
        );
        $this->add($submit);
    }
}
