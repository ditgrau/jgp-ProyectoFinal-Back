<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Event_typeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('event_type')-> insert(
            [
                ['name' => 'competiciones'],
                ['name' => 'entrenamientos'],
                ['name' => 'vacaciones'],
            ]
            );
    }
}
