<?php
namespace Events\Traits;

use Laminas\Form\Form;

trait RegistrationFormTrait
{
    protected $registrationForm;
    public function setRegistrationForm(Form $form)
    {
        $this->registrationForm = $form;
    }
}
