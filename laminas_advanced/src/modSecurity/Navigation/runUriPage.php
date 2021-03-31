<?php
/**
 * Code Runner
 */
use src\modSecurity\Navigation\UriPage;
use Laminas\Navigation\Page\AbstractPage;
require __DIR__ . '/../../../vendor/autoload.php';
$page = new UriPage([
    'label' => 'Some page',
    'name' => 'Some name',
    'uri' => 'http://www.example.com/'
]);
var_dump($page);

// Using a factory
$page = AbstractPage::factory([
    'label' => 'Some page',
    'name' => 'Some name',
    'uri'   => 'http://www.example.com/',
]);
var_dump($page);
