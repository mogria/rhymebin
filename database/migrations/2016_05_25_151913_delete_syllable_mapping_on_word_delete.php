<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteSyllableMappingOnWordDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('syllable_mappings', function (Blueprint $table) {
            $table->dropForeign('syllable_mappings_word_id_foreign');
            $table->foreign('word_id')->references('id')->on('words')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('syllable_mappings', function (Blueprint $table) {
            $table->dropForeign('syllable_mappings_word_id_foreign');
            $table->foreign('word_id')->references('id')->on('words');
        });
    }
}
