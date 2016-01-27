<?php

// Load application
require_once __DIR__ . '/../vendor/autoload.php';
$app = new Silex\Application();

// Init console
use Knp\Provider\ConsoleServiceProvider;
$app->register(new ConsoleServiceProvider(), array(
    'console.name'              => 'Mikko Test',
    'console.version'           => '1.0.0',
    'console.project_directory' => __DIR__.'/..'
));