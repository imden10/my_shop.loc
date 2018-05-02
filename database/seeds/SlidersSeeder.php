<?php

use Illuminate\Database\Seeder;

class SlidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0;$i<3;$i++)
        {
            DB::table('sliders')->insert([
                'image' => str_random(10),
                'title' => str_random(10)
            ]);
        }
    }
}
