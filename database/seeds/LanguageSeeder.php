<?php

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder {

    public function run() {
        echo "RhymeBin: adding languages\n";
        DB::table('languages')->insert([
            ['id' => 1, 'name' => 'English'],
            ['id' => 2, 'name' => 'Schwiizerdütsch']
        ]);


    }
}
