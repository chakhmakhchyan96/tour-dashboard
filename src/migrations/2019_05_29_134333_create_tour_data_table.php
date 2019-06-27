<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tour_id');
            $table->string('language');
            $table->string('short_title')->nullable();
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->text('short_content')->nullable();
            $table->text('duration')->nullable();
            $table->text('date_info')->nullable();
            $table->text('gallery_text')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
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
        Schema::dropIfExists('tour_data');
    }
}
