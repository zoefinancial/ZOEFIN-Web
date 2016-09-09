<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvestmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('investments', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('users_id')->index('fk_investments_users1_idx');
			$table->integer('individuals_id')->index('fk_investments_individuals1_idx');
			$table->integer('investment_vehicles_id')->index('fk_investments_investment_vehicles1_idx');
			$table->string('name', 45)->nullable();
			$table->string('investment_company_name', 45)->nullable();
			$table->integer('balance')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('investments');
	}

}
