<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUniqueIndexFromSyllable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('syllables', function (Blueprint $table) {
            $table->dropUnique('syllables_syllable_unique');
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
            $table->unique('syllable');
        });
    }
}
