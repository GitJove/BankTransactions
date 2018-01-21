<?php

use Illuminate\Database\Seeder;

class ContinentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('continents')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Asia',
                'code' => 'as',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Europe',
                'code' => 'eu',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Africa',
                'code' => 'af',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Oceania',
                'code' => 'oc',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Antarctica',
                'code' => 'an',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'North America',
                'code' => 'na',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'South America',
                'code' => 'sa',
            ),
        ));
    }
}
