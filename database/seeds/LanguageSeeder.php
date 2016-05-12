<?php

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder {

    public function run() {
        echo "RhymeBin: adding languages\n";
        DB::table('languages')->insert([
            ['name' => 'Deutsch'],
            ['name' => 'Schwiizerdütsch'],
            ['name' => 'English']
        ]);


    }
}
