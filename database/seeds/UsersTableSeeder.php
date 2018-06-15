<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('users')->insert([
            'name' => 'Demo Admin',
            'email' => 'admin@demo.com',
            'password' => Hash::make('demo'),
            'api_token' => str_random(60),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

    }
}
