<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RescaleSyllableIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::update(<<<UPDATESYLLABLENUMBER
UPDATE
        syllable_mappings
SET
        syllable_number = syllable_number -
            CAST(
                (SELECT syllable_count from words WHERE words.id = syllable_mappings.word_id)
                AS SIGNED INTEGER
            ) - 1
UPDATESYLLABLENUMBER
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::update(<<<UPDATESYLLABLENUMBER
UPDATE
        syllable_mappings
SET
        syllable_number = syllable_number +
            CAST(
                (SELECT syllable_count from words WHERE words.id = syllable_mappings.word_id)
                AS SIGNED INTEGER
            ) + 1
UPDATESYLLABLENUMBER
        );
    }
}
