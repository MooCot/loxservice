<?php
use Slim\Factory\AppFactory;
use App\Middleware\CORSMiddleware;
use App\Middleware\ErrorHandlerMiddleware;
use Psr\Log\LoggerInterface;

require __DIR__ . '/../vendor/autoload.php';
    
$container = require __DIR__ . '/../config/dependencies.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
$app = $container->get(AppFactory::class)->create();

$app->add(new CORSMiddleware());
$app->add(new ErrorHandlerMiddleware($container->get(LoggerInterface::class)));

$routes = require __DIR__ . '/../routes/api.php';
$routes($app);
$app->run();
