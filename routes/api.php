<?php
use App\Controllers\SubscriptionController;

return function ($app) {
	// Маршрут для POST-запроса на /subscribe
	$app->post('/subscribe', SubscriptionController::class . ':subscribe');

	// Маршрут для GET-запроса на /
	$app->get('/', function ($request, $response, $args) {
		$response->getBody()->write("Welcome to the API!");
		return $response;
	});
};