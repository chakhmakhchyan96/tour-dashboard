<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateToursTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tours', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('price')->default(0);
			$table->string('slug');
			$table->boolean('status')->default(0);
			$table->integer('age_from')->nullable();
			$table->text('map', 65535)->nullable();
			$table->timestamps();
			$table->dateTime('start_date')->nullable();
			$table->dateTime('end_date')->nullable();
			$table->string('start_time')->nullable();
			$table->string('end_time')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tours');
	}

}
