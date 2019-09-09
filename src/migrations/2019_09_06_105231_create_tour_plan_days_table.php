<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTourPlanDaysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tour_plan_days', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->timestamps();
			$table->integer('tour_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tour_plan_days');
	}

}
