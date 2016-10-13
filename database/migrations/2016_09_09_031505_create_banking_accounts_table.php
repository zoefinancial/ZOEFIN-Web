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
			$table->increments('id');
			$table->integer('users_id')->index('fk_accounts_users_idx');
			$table->integer('banks_id')->index('fk_banking_accounts_banks_idx');
			$table->integer('account_types_id')->index('fk_accounts_account_types_idx');
			$table->integer('account_status_id')->index('fk_accounts_account_status_idx');
            $table->integer('account_quovo_id')->nullable();
            $table->integer('quovo_id')->nullable();
            $table->boolean('active')->nullable;
            $table->string('name', 20)->nullable();
            $table->decimal('current_balance',16,4);
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
		Schema::drop('banking_accounts');
	}

}
