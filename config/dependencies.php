<?php
use App\Repositories\SubscriptionRepository;
use DI\Container;
use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as Capsule;
use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
    foreach ($_ENV as $key => $value) {
        putenv("$key=$value");
    }
    $dotenv->required([
        'DB_HOST',
        'DB_DATABASE', 
        'DB_USERNAME'
    ])->notEmpty();
} catch (\Dotenv\Exception\ValidationException $e) {
    die('Ошибка валидации переменных окружения: ' . $e->getMessage());
} catch (\Throwable $e) {
    die('Ошибка загрузки переменных окружения: ' . $e->getMessage());
}

$container = new Container();
$container->set(LoggerInterface::class, function () {
	$logger = new Logger('app');
	$logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/app.log', Logger::DEBUG));
	$logger->pushHandler(new RotatingFileHandler(
		__DIR__ . '/../logs/app.log',
		30,
		Logger::WARNING
	));
	
	$formatter = new LineFormatter(
		"[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n",
		"Y-m-d H:i:s"
	);
	return $logger;
});
$container->set('db', function () {
	$capsule = new Capsule();
	$capsule->addConnection(require __DIR__ . '/../config/database.php');
	$capsule->setAsGlobal();
	$capsule->bootEloquent();
	return $capsule;
});

$container->set(SubscriptionRepository::class, function ($container) {
	return new SubscriptionRepository();
});
$container->set(App\Controllers\SubscriptionController::class, function ($container) {
	return new App\Controllers\SubscriptionController($container->get(SubscriptionRepository::class));
});

return $container;