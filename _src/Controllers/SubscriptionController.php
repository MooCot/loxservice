<?php

namespace App\Controllers;

use App\Repositories\SubscriptionRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SubscriptionController
{
	private SubscriptionRepository $subscriptionRepository;

	public function __construct(SubscriptionRepository $priceRepository)
	{
		$this->subscriptionRepository = $priceRepository;
	}

	public function subscribe(Request $request, Response $response): Response
	{
		$data = $request->getParsedBody();
		$adUrl = $data['ad_url'];
		$email = $data['email'];
		$qwery= $this->subscriptionRepository->getSubscriptionByAdUrl('test');
		$response->getBody()->write(json_encode(['status' => 'success', 'qwery'=>$qwery,'email'=>$email]));
		return $response->withHeader('Content-Type', 'application/json');
	}
	public function test(Request $request, Response $response): Response
	{
		$response->getBody()->write(json_encode(['status' => 'success']));
		return $response->withHeader('Content-Type', 'application/json');
	}
}