<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBankingAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('banking_accounts', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('users_id')->index('fk_accounts_users1_idx');
			$table->integer('banks_id')->index('fk_banking_accounts_banks1_idx');
			$table->integer('account_types_id')->index('fk_accounts_account_types1_idx');
			$table->integer('account_status_id')->index('fk_accounts_account_status1_idx');
			$table->integer('current_balance');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('banking_accounts');
	}

}
