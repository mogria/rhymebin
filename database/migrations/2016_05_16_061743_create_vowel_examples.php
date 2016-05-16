<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVowelExamples extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vowel_examples', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vowel_id')->unsigned();
            $table->integer('language_id')->unsigned();
            $table->string('word');
            $table->foreign('vowel_id')->references('id')->on('vowels');
            $table->foreign('language_id')->references('id')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vowel_examples');
    }
}
