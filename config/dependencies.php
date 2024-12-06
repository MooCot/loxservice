<?php
use App\Repositories\SubscriptionRepository;
use DI\Container;
use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as Capsule;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
foreach ($_ENV as $key => $value) {
	putenv("$key=$value");
}
$container = new Container();

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