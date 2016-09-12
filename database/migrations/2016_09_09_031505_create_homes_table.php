<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHomesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('homes', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('users_id')->index('fk_homes_users1_idx');
			$table->integer('home_types_id')->index('fk_homes_home_types1_idx');
			$table->integer('investments_id')->nullable()->index('fk_homes_investments1_idx');
			$table->string('address', 45)->nullable();
			$table->string('city', 45)->nullable();
			$table->string('state', 45)->nullable();
			$table->integer('zip')->nullable();
			$table->integer('current_value')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('homes');
	}

}
