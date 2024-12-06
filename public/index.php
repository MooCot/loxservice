<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = require __DIR__ . '/../config/dependencies.php';

$app = $container->get(AppFactory::class)->create();

$routes = require __DIR__ . '/../routes/api.php';
$routes($app);

$app->run();
