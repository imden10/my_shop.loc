<?php

use Illuminate\Database\Seeder;

class FeatureVariantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('feature_variants')->insert([
            'variant' => 'Мужские',
            'feature_id' => 1
        ]);
        DB::table('feature_variants')->insert([
            'variant' => 'Женские',
            'feature_id' => 1
        ]);
        DB::table('feature_variants')->insert([
            'variant' => 'Механические',
            'feature_id' => 2
        ]);
        DB::table('feature_variants')->insert([
            'variant' => 'Кварцовые',
            'feature_id' => 2
        ]);
        DB::table('feature_variants')->insert([
            'variant' => 'Минеральное',
            'feature_id' => 3
        ]);
        DB::table('feature_variants')->insert([
            'variant' => 'Сапфировое',
            'feature_id' => 3
        ]);
        DB::table('feature_variants')->insert([
            'variant' => 'Будильник',
            'feature_id' => 4
        ]);
        DB::table('feature_variants')->insert([
            'variant' => 'Секундомер',
            'feature_id' => 4
        ]);
        DB::table('feature_variants')->insert([
            'variant' => 'Таймер',
            'feature_id' => 4
        ]);
        DB::table('feature_variants')->insert([
            'variant' => 'Компас',
            'feature_id' => 4
        ]);
    }
}
