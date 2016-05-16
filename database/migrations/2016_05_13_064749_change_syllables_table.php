<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSyllablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('syllables', function (Blueprint $table) {
            $table->dropColumn('start_index');
            $table->dropColumn('end_index');
            $table->dropForeign('syllables_word_id_foreign');
            $table->dropColumn('word_id');
            $table->string('syllable')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('syllables', function (Blueprint $table) {
            $table->integer('start_index')->unsigned();
            $table->integer('end_index')->unsigned();
            $table->integer('word_id')->unsigned();
            $table->foreign('word_id')->references('id')->on('words');
            $table->dropColumn('syllable');
        });
    }
}
