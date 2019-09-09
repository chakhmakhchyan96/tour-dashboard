<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (!Schema::hasTable('images')) {
            Schema::create('images', function (Blueprint $table) {
                $table->bigInteger('id', true)->unsigned();
                $table->string('resource_type');
                $table->integer('resource_id');
                $table->string('key')->nullable();
                $table->string('type')->default('image');
                $table->string('path');
                $table->timestamps();
            });
        }
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('images');
	}

}
