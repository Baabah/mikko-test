<?php

// Load application
require_once __DIR__ . '/../vendor/autoload.php';
$app = new Silex\Application();

echo 'hello world';

return $app;