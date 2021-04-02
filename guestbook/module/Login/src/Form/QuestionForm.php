<?php
namespace Login\Form;

use Laminas\Form\Form;
use Laminas\InputFilter\InputFilterInterface;

class QuestionForm extends Form
{
    public function __construct(InputFilterInterface $inputFilter){
        parent::__construct(__CLASS__, null);
        $this->setInputFilter($inputFilter);

        $question = new Text('security_question');
        $question->setLabel('Security Question');
        $this->add($question);

        $answer = new Text('security_answer');
        $answer->setLabel('Security Question');
        $this->add($answer);
    }
}
