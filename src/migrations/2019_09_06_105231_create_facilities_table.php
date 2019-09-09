<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFacilitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
    {
        if (!Schema::hasTable('facilities')) {

            Schema::create('facilities', function (Blueprint $table) {
                $table->bigInteger('id', true)->unsigned();
                $table->boolean('status')->default(1);
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
		Schema::drop('facilities');
	}

}
