<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSyllableMappings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syllable_mappings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('syllable_id')->unsigned();
            $table->integer('word_id')->unsigned();
            $table->integer('syllable_number');
            $table->timestamps();
            $table->foreign('word_id')->references('id')->on('words');
            $table->foreign('syllable_id')->references('id')->on('syllables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('syllable_mappings');
    }
}
