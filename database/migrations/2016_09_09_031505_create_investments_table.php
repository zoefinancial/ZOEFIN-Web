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
			$table->increments('id');
			$table->integer('users_id')->index('fk_investments_users_idx');
			$table->integer('individuals_id')->index('fk_investments_individuals_idx');
			$table->integer('investment_vehicles_id')->index('fk_investments_investment_vehicles_idx');
            $table->integer('investment_companies_id')->index('fk_investments_investment_companies_idx');
			$table->string('employer', 255)->nullable();
			$table->integer('total_balance')->nullable();
            $table->date('initial');
            $table->date('end');
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
		Schema::drop('investments');
	}

}
