<?php
/**
 * runFieldsetsAndForms runtime
 */
require __DIR__ . '/../../../vendor/autoload.php';
use src\modFormsAndHydration\FieldsetsAndForms\UserController;
$controller = new UserController();
echo $controller->indexAction();
