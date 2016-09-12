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
			$table->string('description', 45)->nullable();
			$table->binary('tax_deffered', 1)->nullable();
			$table->binary('pre_tax', 1);
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
