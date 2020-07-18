<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
       

        \App\Category::create(['name'=>'Nature']);
        \App\Category::create(['name'=>'Food']);
        \App\Category::create(['name'=>'Home Design']);
        \App\Category::create(['name'=>'Health']);
        \App\Category::create(['name'=>'Technology']);
        \App\Category::create(['name'=>'Space']);
    }
}
