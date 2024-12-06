<?php

namespace App\Repositories;
use App\Models\Subscription;
class SubscriptionRepository
{
	// Получить подписку по URL объявления
	public function getSubscriptionByAdUrl(string $adUrl)
	{
		return Subscription::where('ad_url', $adUrl)->first(); // Найти первую подписку по URL
	}

	// Создать новую подписку
	public function createSubscription(string $adUrl, string $email, int $price)
	{
		return Subscription::create([
			'ad_url' => $adUrl,
			'email' => $email,
			'price' => $price,
		]);
	}

	// Обновить цену для подписки по URL объявления
	public function updatePrice(string $adUrl, int $newPrice)
	{
		$subscription = $this->getSubscriptionByAdUrl($adUrl);
		if ($subscription) {
			$subscription->price = $newPrice;
			$subscription->save();
		}
	}
}