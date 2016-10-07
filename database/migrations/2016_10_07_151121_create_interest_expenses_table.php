<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterestExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('users_id')->index('fk_loans_users_idx');
            $table->integer('individuals_id')->index('fk_loans_individuals_idx');
            $table->integer('expense_types_id')->index('fk_expenses_expense_types_idx');
            $table->integer('fiscal_tax_periods_id')->index('fk_fiscal_tax_periods_fiscal_tax_periods_idx');
            $table->date('date');
            $table->decimal('value',32,2);
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
        Schema::drop('expenses');
    }
}
