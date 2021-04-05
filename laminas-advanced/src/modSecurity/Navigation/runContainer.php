<?php
/**
 * Code Runner
 */
use Laminas\Navigation\Navigation;
require __DIR__ . '/../../../vendor/autoload.php';
$config = require '../../config/config.php';
$container = new Navigation($config['navigation']);
var_dump($container);