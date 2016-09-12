<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIndividualsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('individuals', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('users_id')->index('fk_profiles_users1_idx');
			$table->integer('marital_status_id')->index('fk_user_profiles_marital_status1_idx');
			$table->string('name', 45)->nullable();
			$table->string('lastname', 45)->nullable();
			$table->date('datebirth')->nullable();
			$table->string('gender', 45)->nullable();
			$table->string('phone', 45)->nullable();
			$table->string('mobile', 45)->nullable();
			$table->integer('salary');
			$table->integer('bonus')->nullable();
			$table->boolean('principal')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('individuals');
	}

}
