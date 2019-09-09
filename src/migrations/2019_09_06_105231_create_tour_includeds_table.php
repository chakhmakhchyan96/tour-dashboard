<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTourIncludedsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tour_includeds', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('tour_id');
			$table->string('language');
			$table->string('text')->nullable();
			$table->timestamps();
			$table->integer('mirror');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tour_includeds');
	}

}
