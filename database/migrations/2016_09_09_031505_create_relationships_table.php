<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRelationshipsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('relationships', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('individuals_id')->index('fk_relationship_individuals_idx');
			$table->integer('relative_id')->index('fk_relative_idx');
			$table->integer('relationship_types_id')->index('fk_relationship_relationship_types_idx');
			$table->date('date_start');
			$table->date('date_end')->nullable();
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
		Schema::drop('relationships');
	}

}
