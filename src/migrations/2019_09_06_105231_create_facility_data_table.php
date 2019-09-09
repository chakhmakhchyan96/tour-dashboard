<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFacilityDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (!Schema::hasTable('facility_data')) {

            Schema::create('facility_data', function (Blueprint $table) {
                $table->bigInteger('id', true)->unsigned();
                $table->integer('facility_id');
                $table->string('language');
                $table->string('name');
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
		Schema::drop('facility_data');
	}

}
