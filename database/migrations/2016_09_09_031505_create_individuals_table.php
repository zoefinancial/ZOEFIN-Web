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
			$table->increments('id');
			$table->integer('users_id')->index('fk_profiles_users1_idx');
			$table->integer('marital_status_id')->index('fk_user_profiles_marital_status1_idx')->nullable();
			$table->string('name', 50)->nullable();
			$table->string('lastname', 50)->nullable();
			$table->date('datebirth')->nullable();
			$table->string('gender', 1)->nullable();
			$table->string('phone', 20)->nullable();
			$table->string('mobile', 20)->nullable();
			$table->integer('salary')->nullable();
			$table->integer('bonus')->nullable();
			$table->boolean('principal')->default(0);
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
		Schema::drop('individuals');
	}

}
