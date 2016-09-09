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
			$table->integer('id', true);
			$table->integer('users_id')->index('fk_loans_users1_idx');
			$table->integer('individuals_id')->index('fk_loans_individuals1_idx');
			$table->integer('loan_status_id')->index('fk_loans_loan_status1_idx');
			$table->integer('loan_types_id')->index('fk_loans_loan_types1_idx');
			$table->string('amount', 45)->nullable();
			$table->string('period', 45)->nullable();
			$table->date('first_payment')->nullable();
			$table->date('last_payment')->nullable();
			$table->text('comments', 65535)->nullable();
			$table->string('details', 45)->nullable();
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
