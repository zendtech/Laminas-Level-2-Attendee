<?php
/**
 * runAutoHydration runtime
 */
use src\modDatabaseModeling\Hydrators\ClassMethodsHydrator\UserEntity;
use Laminas\Form\{Form, Element, FormInterface};
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\InputFilter\{InputFilter, Input};
require __DIR__ . '/../../../vendor/autoload.php';
$_POST['id'] = 3;
$_POST['firstName'] = 'Mark';
$id = new Input('id');
$id->getFilterChain()->attachByName('int');

$firstName = new Input('firstName');
$firstName->getFilterChain()->attachByName('stringToLower');

$filter = (new InputFilter)
    ->add($id, 'id')
    ->add($firstName, 'firstName');

$form = (new Form)
    ->add(new Element('id'))
    ->add(new Element('firstName'))
    ->setInputFilter($filter)
    ->setHydrator(new ClassMethodsHydrator())
    ->setData(['id' => $_POST['id'], 'firstName' => $_POST['firstName']])
    ->bind(new UserEntity());

if ($form->isValid()) {
    $user = $form->getData(FormInterface::VALUES_NORMALIZED);
    var_dump($user);
}
