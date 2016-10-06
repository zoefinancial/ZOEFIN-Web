<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuovoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quovo_users', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->index('fk_users_user_idx');;
            $table->integer('quovo_user_id')->index('fk_quovo_quovo_user_idx');
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
        Schema::drop('quovo_users');
    }
}
