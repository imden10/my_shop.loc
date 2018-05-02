<?php

use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.df
     *
     * @return voidsd
     */
    public function run()
    {
        for ($i=0;$i<12;$i++)
        {
            DB::table('services')->insert([
                'name' => str_random(10),
                'slug' => str_random(10)
            ]);
        }
    }
}
