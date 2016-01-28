<?php

// Load application
require_once __DIR__ . '/../vendor/autoload.php';
$app = new Silex\Application();

// Init console
$app->register(new \Knp\Provider\ConsoleServiceProvider(), [
    'console.name' => 'Mikko Test',
    'console.version' => '1.0.0',
    'console.project_directory' => __DIR__ . '/..'
]);

// Regiter service providers
$app->register(new \ServiceProviders\PaymentServiceProvider());

// Add payroll command to the console
$console = $app['console'];
$console->add(new \Commands\PayrollDatesCommand());
$console->run();
