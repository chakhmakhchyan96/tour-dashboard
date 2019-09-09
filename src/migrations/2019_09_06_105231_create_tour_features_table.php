<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTourFeaturesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tour_features', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('tour_id');
			$table->string('language');
			$table->string('key');
			$table->string('value');
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
		Schema::drop('tour_features');
	}

}
