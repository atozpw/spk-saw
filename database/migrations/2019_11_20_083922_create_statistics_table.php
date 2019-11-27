<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('criteria_id');
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('value');
            $table->timestamps();

            $table->foreign('position_id')->references('id')->on('positions');
            $table->foreign('criteria_id')->references('id')->on('criterias');
            $table->foreign('player_id')->references('id')->on('players');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statistics');
    }
}
