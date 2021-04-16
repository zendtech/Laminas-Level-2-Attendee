<?php
/**
 * UserController
 */
namespace src\modFormsAndHydration\FieldsetsAndForms;
use src\core\AbstractController;
class UserController extends AbstractController
{
    public function indexAction(){
        $form = new UserForm('user_form');
        $form->bind(new UserEntity());
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
        }
        require 'UserForm.phtml';
    }
}
