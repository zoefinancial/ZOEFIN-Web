<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvesHasAssetClassesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inves_has_asset_classes', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('investments_id')->index('fk_investments_has_asset_classes_investments1_idx');
			$table->integer('asset_classes_id')->index('fk_investments_has_asset_classes_asset_classes1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('inves_has_asset_classes');
	}

}
