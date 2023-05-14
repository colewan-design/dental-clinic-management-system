<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
 

     public function run()
     {
         // Create a Superadmin user
         DB::table('users')->insert([
            'account_id' => 'S01',
             'name' => 'Superadmin',
             'email' => 'superadmin@gmail.com',
             'role' => 'Superadmin',
             'password' => Hash::make('superadmin')
         ]);

     }
}
