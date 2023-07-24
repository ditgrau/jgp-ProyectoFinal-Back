<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')-> insert([
            [
                'role_id' => 1,
                'name' => 'admin',
                'surname' => 'admin',
                'email' => 'admin@admin.com', 
                'password' => bcrypt('Admin-1234'),
                'confirmed' => true
            ],
            [
                'role_id' => 2,
                'name' => 'coach',
                'surname' => 'coach',
                'email' => 'coach@coach.com', 
                'password' => bcrypt('Coach-1234'),
                'confirmed' => true
            ],
            [
                'role_id' => 3,
                'name' => 'gimnasta',
                'surname' => 'gimnasta',
                'email' => 'gimnasta@gimnasta.com', 
                'password' => bcrypt('Gimnasta-1234'),
                'confirmed' => true
            ]
        ]);
    }
}
