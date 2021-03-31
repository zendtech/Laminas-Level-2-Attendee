<?php
/**
 * FormDelegator
 */
namespace Market\Form\Delegator;
use Zend\Form\Element\Csrf;
use Zend\Form\Form;
use Zend\Form\FormInterface;

class FormDelegator extends Form {
    protected $form;
    public function __construct(FormInterface $form) {
        $this->form = $form->add(new Csrf('hash'));
    }

    public function getForm(): \Zend\Form\FieldsetInterface {
        return $this->form;
    }
}