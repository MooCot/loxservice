<?php

namespace App\Controllers;

use App\Services\PriceMonitorService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Repositories\SubscriptionRepository;

class SubscriptionController
{
	private SubscriptionRepository $priceRepository;

	public function __construct(PriceRepository $priceRepository)
	{
		$this->priceRepository = $priceRepository;
	}

	public function subscribe(Request $request, Response $response): Response
	{
		$data = $request->getParsedBody();
		$adUrl = $data['ad_url'];
		$email = $data['email'];

		// Создаем подписку
		$this->priceMonitorService->subscribe($adUrl, $email);

		$response->getBody()->write(json_encode(['status' => 'success']));
		return $response->withHeader('Content-Type', 'application/json');
	}
}