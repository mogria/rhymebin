<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveVowelIdToSyllableMapping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('syllables', function(Blueprint $table) {
            $table->dropForeign('syllables_vowel_id_foreign');
            $table->dropColumn('vowel_id');
        });

        Schema::table('syllable_mappings', function(Blueprint $table) {
            $table->integer('vowel_id')->unsigned();
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
        Schema::table('syllables', function(Blueprint $table) {
            $table->integer('vowel_id')->unsigned();
            $table->foreign('vowel_id')->references('id')->on('vowels');
        });

        Schema::table('syllable_mappings', function(Blueprint $table) {
            $table->dropForeign('syllable_mappings_vowel_id_foreign');
            $table->dropColumn('vowel_id');
        });
    }
}
