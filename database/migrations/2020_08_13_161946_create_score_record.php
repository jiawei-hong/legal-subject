<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_record', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('s_id')->unsigned()->index();
            $table->foreign('s_id')->references('id')->on('score');
            $table->bigInteger('question_id')->unsigned()->index();
            $table->foreign('question_id')->references('id')->on('questions');
            $table->boolean('correct');
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
        Schema::dropIfExists('score_record');
    }
}
