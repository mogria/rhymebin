<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {

    public function run() {
        // only seed the users table once because their names must be unique
        $user = DB::table('users')->where('name', 'Mogria')->first();
        if($user === null) {
            echo "RhymeBin: creating default user 'Mogria' with password 'testtest'\n";
            DB::table('users')->insert([
                'name' => 'Mogria',
                'email' => 'm0gr14@gmail.com',
                'password' => Hash::make('testtest')
            ]);
        }

    }
}
