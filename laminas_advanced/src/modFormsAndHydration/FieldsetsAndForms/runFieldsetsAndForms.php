<?php
/**
 * runFieldsetsAndForms runtime
 */
use src\modFormsAndHydration\FieldsetsAndForms\UserController;
require __DIR__ . '/../../../vendor/autoload.php';
$controller = new UserController();
echo $controller->indexAction();
