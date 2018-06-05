<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class VariablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('variables')->insert([
                'key' => 'site-brand',
                'value' => 'site-brand'
        ]);
        DB::table('variables')->insert([
                'key' => 'site-title',
                'value' => 'site-title'
        ]);
        DB::table('variables')->insert([
            'key' => 'footer-text',
            'value' => 'footer-text'
        ]);
        DB::table('variables')->insert([
                'key' => 'email',
                'value' => ''
        ]);
        DB::table('variables')->insert([
                'key' => 'behance',
                'value' => ''
        ]);
        DB::table('variables')->insert([
                'key' => 'dribbble',
                'value' => ''
        ]);
        DB::table('variables')->insert([
                'key' => 'github',
                'value' => ''
        ]);
        DB::table('variables')->insert([
                'key' => 'linkedin',
                'value' => ''
        ]);
        DB::table('variables')->insert([
                'key' => 'twitter',
                'value' => ''
        ]);



    }
}
