<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvestmentVehiclesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('investment_vehicles', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('description', 100);
            $table->boolean('tax_deferred');
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
		Schema::drop('investment_vehicles');
	}

}
