<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('status')->default(0);
            $table->integer('tour_id');
            $table->string('name')->nullable();
            $table->text('comment')->nullable();
            $table->string('email')->nullable();
            $table->integer('transport')->nullable();
            $table->integer('accommodation')->nullable();
            $table->integer('food_beverages')->nullable();
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
        Schema::dropIfExists('tour_reviews');
    }
}
