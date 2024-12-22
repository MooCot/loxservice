<?php
use App\Controllers\SubscriptionController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function ($app) {
	// Маршрут для POST-запроса на /subscribe
//	$app->post('/subscribe', SubscriptionController::class . ':subscribe');
//	$app->get('/subscribe', SubscriptionController::class . ':test');

	$app->get('/', function (Request $request, Response $response) {
		$response->getBody()->write("Welcome to the API2!");
		return $response;
	});
};