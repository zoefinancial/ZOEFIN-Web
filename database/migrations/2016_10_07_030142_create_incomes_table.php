<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('users_id')->index('fk_accounts_users_idx');
            $table->integer('individuals_id')->index('fk_individuals_individuals_idx');
            $table->integer('income_types_id')->index('fk_income_types_income_types_idx');
            $table->integer('fiscal_tax_periods_id')->index('fk_fiscal_tax_periods_fiscal_tax_periods_idx');
            $table->integer('bank_id')->index('fk_incomes_bank_idx');
            $table->date('date');
            $table->decimal('value',32,2);
            $table->integer('quovo_transaction_id');
            $table->integer('loan_id');
            $table->integer('banking_account_id');
            $table->string('description',128);
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
        Schema::drop('incomes');
    }
}
