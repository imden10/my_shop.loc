<?php

use Illuminate\Database\Seeder;

class BanerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    }
} DB::table('baners')->insert([
    'text' => 'ООО Транс - Логистик',
    'logo' => 'ban_img.png',
    'slogan' => 'Слоган'
]);

