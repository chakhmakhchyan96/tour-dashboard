<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTourDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tour_data', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('tour_id');
			$table->string('language');
			$table->string('short_title')->nullable();
			$table->string('title')->nullable();
			$table->text('content', 65535)->nullable();
			$table->text('short_content', 65535)->nullable();
			$table->text('duration', 65535)->nullable();
			$table->text('date_info', 65535)->nullable();
			$table->text('gallery_text', 65535)->nullable();
			$table->string('meta_title')->nullable();
			$table->text('meta_description', 65535)->nullable();
			$table->text('meta_keywords', 65535)->nullable();
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
		Schema::drop('tour_data');
	}

}
