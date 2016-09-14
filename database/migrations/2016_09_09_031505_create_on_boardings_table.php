<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOnBoardingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('on_boardings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('marital_status_id')->index('fk_user_profiles_marital_status_idx');
			$table->date('date_birth');
			$table->string('gender', 45)->nullable();
			$table->integer('income');
            $table->ipAddress('visitor_ip')->nullable();
            $table->text('visitor_data')->nullable();
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
		Schema::drop('on_boardings');
	}

}
