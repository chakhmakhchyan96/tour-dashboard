<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
    {
        if (!Schema::hasTable('category_data')) {

            Schema::create('category_data', function (Blueprint $table) {
                $table->bigInteger('id', true)->unsigned();
                $table->integer('category_id');
                $table->string('language');
                $table->string('name')->nullable();
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
		Schema::drop('category_data');
	}

}
