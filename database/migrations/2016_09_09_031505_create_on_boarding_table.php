<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOnBoardingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('on_boarding', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('marital_status_id')->index('fk_user_profiles_marital_status_idx');
            $table->integer('relationship_types_id')->index('fk_on_boarding_relationship_types_idx');
            $table->integer('relative_id')->nullable()->index('fk_on_boarding_on_boarding_idx');
			$table->date('date_birth');
			$table->string('gender', 45)->nullable();
			$table->integer('income');
            $table->ipAddress('visitor_ip');
            $table->text('visitor_data');
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
		Schema::drop('on_boarding');
	}

}
