<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInsuranceInformationTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_information', function(Blueprint $table)
        {
            $table->increments('id')->primary();
            $table->integer('individuals_id')->index('fk_insurance_information_individuals1_idx');
            $table->decimal('total_family_need',16,4);
            $table->decimal('available_resources',16,4);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('insurance_information');
    }

}
