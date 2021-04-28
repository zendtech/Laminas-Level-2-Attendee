<?php
/**
 * Code Runner
 */
use src\modSecurity\Navigation\UriPage;
use Laminas\Navigation\Page\AbstractPage;
require __DIR__ . '/../../../vendor/autoload.php';
$page = new UriPage([
    'label' => 'Zend Training',
    'name' => 'training',
    'uri' => 'https://www.zend.com/training/php'
]);
var_dump($page);

// Using a factory
$page = AbstractPage::factory([
    'label' => 'Perforce',
    'name' => 'perforce',
    'uri'   => 'https://www.perforce.com/',
]);
var_dump($page);
