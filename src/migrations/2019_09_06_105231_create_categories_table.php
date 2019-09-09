<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
    {
        if (!Schema::hasTable('categories')) {

            Schema::create('categories', function (Blueprint $table) {
                $table->bigInteger('id', true)->unsigned();
                $table->timestamps();
                $table->boolean('status')->default(0);
                $table->string('type')->default('tour');
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
		Schema::drop('categories');
	}

}
