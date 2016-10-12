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
			$table->integer('individuals_id')->index('fk_investments_individuals_idx')->nullable();
            $table->integer('investments_id')->index('fk_investments_investments_idx')->nullable();
			$table->integer('investment_vehicles_id')->index('fk_investments_investment_vehicles_idx');
            $table->integer('investment_companies_id')->index('fk_investments_investment_companies_idx');
            $table->integer('account_quovo_id')->nullable();
            $table->integer('quovo_id')->nullable();
            $table->boolean('active')->nullable;
            $table->string('employer', 255)->nullable();
            $table->string('name', 20)->nullable();
            $table->decimal('total_balance',16,4)->nullable();
            $table->date('initial')->nullable();
            $table->date('end')->nullable();
            $table->integer('quovo_last_change')->nullable();
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
