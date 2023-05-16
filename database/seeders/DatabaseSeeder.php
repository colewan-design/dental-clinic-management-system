<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //factory classess
        \App\Models\patient::factory(10)->create();
        \App\Models\dentist::factory(10)->create();
        $this->call([
        
               //-------wag gagalawin--------------------//
               UserSeeder::class,
               // AssignExamSeeder::class,
                //AssignQuizSeeder::class,
                //-----------------------------------------//
        ]);
    }
}

