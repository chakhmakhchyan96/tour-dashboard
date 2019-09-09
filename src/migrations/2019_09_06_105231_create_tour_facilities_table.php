<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTourFacilitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tour_facilities', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('tour_id');
			$table->integer('facility_id');
			$table->string('type')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tour_facilities');
	}

}
