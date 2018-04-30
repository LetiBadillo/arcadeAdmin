<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('question');
            $table->unsignedInteger('subject_id');
            $table->integer('score');
            $table->integer('difficulty');
            $table->unsignedInteger('author_id');
            $table->integer('enabled')->default(1);

            $table->timestamps();

            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('author_id')->references('id')->on('users');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
