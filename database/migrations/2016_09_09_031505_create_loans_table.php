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
            $table->integer('bank_id')->index('fk_loans_banks_idx');
            $table->integer('account_quovo_id')->nullable();
            $table->integer('quovo_id')->nullable();
            $table->boolean('active')->nullable();
            $table->decimal('amount',32,2);
            $table->decimal('interest_rate',4,2)->nullable();
            $table->string('period', 60)->nullable();
            $table->date('first_payment')->nullable();
            $table->date('last_payment')->nullable();
            $table->string('name', 20)->nullable(); // number
            $table->text('comments', 1000)->nullable();
			$table->string('details', 100)->nullable();
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
		Schema::drop('loans');
	}

}
