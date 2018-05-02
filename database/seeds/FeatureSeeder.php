<?php

use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('features')->insert([
        'name' => 'Тип'
    ]);
        DB::table('features')->insert([
            'name' => 'Механизм'
        ]);
        DB::table('features')->insert([
            'name' => 'Стекло'
        ]);
        DB::table('features')->insert([
            'name' => 'Функции'
        ]);
    }
}
