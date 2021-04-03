<?php
/**
 * UserController
 */
namespace src\modFormsAndHydration\FieldsetsAndForms;
use src\core\AbstractController;
class UserController extends AbstractController
{
    public function indexAction(){
        $container = $this->getEvent()->getApplication()->getServiceManager();
        $form = $container->get(UserForm::class);
        $user = $container->get(UserEntity::class);
        $form->bind($user);
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                    var_dump($user);
                }
        }
        require 'UserForm.phtml';
    }
}