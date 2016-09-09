<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRelationshipTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('relationship', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('individuals_id')->index('fk_relationship_individuals1_idx');
			$table->integer('relative_id')->index('fk_relationship_individuals2_idx');
			$table->integer('relationship_types_id')->index('fk_relationship_relationship_types1_idx');
			$table->date('date_start');
			$table->date('date_end')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('relationship');
	}

}
