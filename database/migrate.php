<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Filesystem\Filesystem;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

// Настроим dotenv
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
foreach ($_ENV as $key => $value) {
	putenv("$key=$value");
}

// Настройка Capsule для работы с базой данных
$capsule = new Capsule();
$capsule->addConnection(require __DIR__ . '/../config/database.php');
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Создаем репозиторий миграций
$repository = new DatabaseMigrationRepository($capsule->getDatabaseManager(), 'migrations');

// Проверяем, существует ли таблица для миграций
if (!$repository->repositoryExists()) {
	$repository->createRepository();
}

// Создаем экземпляр Filesystem
$filesystem = new Filesystem();

// Создаем мигратор
$migrator = new Migrator($repository, $capsule->getDatabaseManager(), $filesystem);

// Указываем директорию, где хранятся миграции
$migrator->run([__DIR__ . '/migrations']);