<?php
/**
 * FormDelegator
 */
namespace Market\Form\Delegator;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Form;
use Laminas\Form\FormInterface;

class FormDelegator extends Form {
    protected $form;
    public function __construct(FormInterface $form) {
        $this->form = $form->add(new Csrf('hash'));
    }

    public function getForm(): \Laminas\Form\FieldsetInterface {
        return $this->form;
    }
}