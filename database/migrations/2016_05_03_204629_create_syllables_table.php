<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSyllablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syllables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('start_index')->unsigned();
            $table->integer('end_index')->unsigned();
            $table->integer('word_id')->unsigned();
            $table->integer('vowel_id')->unsigned();
            $table->timestamps();
            $table->foreign('word_id')->references('id')->on('words');
            $table->foreign('vowel_id')->references('id')->on('vowels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('syllables');
    }
}
