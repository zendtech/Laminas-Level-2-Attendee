<?php
namespace Events\Traits;

use Zend\Form\Form;

trait RegistrationFormTrait
{
    protected $registrationForm;
    public function setRegistrationForm(Form $form)
    {
        $this->registrationForm = $form;
    }
}
