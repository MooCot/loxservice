<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateSubscriptionsTable extends Migration
{
	/**
	 * Запуск миграции.
	 *
	 * @return void
	 */
	public function up()
	{
		Capsule::schema()->create('subscriptions', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('email')->unique();
			$table->timestamp('subscribed_at')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Откат миграции.
	 *
	 * @return void
	 */
	public function down()
	{
		Capsule::schema()->dropIfExists('subscriptions');
	}
}