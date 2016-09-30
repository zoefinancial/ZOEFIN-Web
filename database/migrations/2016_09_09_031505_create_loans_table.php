<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLoansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('loans', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('users_id')->index('fk_loans_users_idx');
			$table->integer('individuals_id')->index('fk_loans_individuals_idx');
			$table->integer('loan_status_id')->index('fk_loans_loan_status_idx');
			$table->integer('loan_types_id')->index('fk_loans_loan_types_idx');
			$table->integer('amount');
            $table->integer('interest_rate');
			$table->string('period', 60)->nullable();
			$table->date('first_payment')->nullable();
			$table->date('last_payment')->nullable();
			$table->text('comments', 1000)->nullable();
			$table->string('details', 100)->nullable();
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
		Schema::drop('loans');
	}

}
