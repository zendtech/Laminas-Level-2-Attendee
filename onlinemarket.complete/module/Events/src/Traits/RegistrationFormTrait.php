<?php
namespace Events\Traits;

use Zend\Form\Form;

trait RegistrationFormTrait
{
    protected $registrationForm;
    public function setRegistrationForm($form)
    {
        $this->registrationForm = $form;
    }
}
