<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(ContinentTableSeeder::class);
         $this->call(CountryTableSeeder::class);
         $this->call(CityTableSeeder::class);
         $this->call(UsersTableSeeder::class);
         $this->call(TransactionsTableSeeder::class);
    }
}
