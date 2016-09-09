<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFinancialTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('financial_transactions', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('transaction_types_id')->index('fk_financial_transactions_transaction_types1_idx');
			$table->integer('loans_id')->index('fk_financial_transactions_loans1_idx');
			$table->integer('banking_accounts_id')->index('fk_financial_transactions_banking_accounts1_idx');
			$table->integer('investments_id')->index('fk_financial_transactions_investments1_idx');
			$table->dateTime('date')->nullable();
			$table->integer('amount')->nullable();
			$table->string('description', 45)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('financial_transactions');
	}

}
