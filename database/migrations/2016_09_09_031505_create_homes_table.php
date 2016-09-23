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
			$table->increments('id');
			$table->integer('users_id')->index('fk_homes_users_idx');
			$table->integer('home_types_id')->index('fk_homes_home_types_idx');
			$table->integer('investments_id')->nullable()->index('fk_homes_investments_idx');
			$table->string('address', 100);
			$table->string('city', 60);
			$table->string('state', 60);
			$table->integer('zip');
			$table->integer('current_value');
            $table->timestamps();
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
