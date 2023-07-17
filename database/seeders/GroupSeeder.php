<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('group')-> insert([
            [
                'name' => 'Promesas',
                'days' => 'lunes , miercoles',
                'start_hour' => '17:30:00',
                'end_hour' => '19:30:00',
                'location' => 'Pabellon Benimaclet: sala esgrima'
            ],
            [
                'name' => 'Federación',
                'days' => 'lunes, miercoles, viernes',
                'start_hour' => '17:30:00',
                'end_hour' => '20:30:00',
                'location' => 'Pabellon Benimaclet: pista multiusos'
            ],
            [
                'name' => 'Nacional Base',
                'days' => 'lunes, miercoles, jueves, viernes',
                'start_hour' => '17:30:00',
                'end_hour' => '20:30:00',
                'location' => 'Pabellon Benimaclet: pista multiusos'
            ],
            [
                'name' => 'Absoluto',
                'days' => 'lunes, miercoles, jueves, viernes',
                'start_hour' => '17:30:00',
                'end_hour' => '20:30:00',
                'location' => 'Pabellon Benimaclet: pista multiusos'
            ],
            [
                'name' => 'Ballet',
                'days' => 'martes',
                'start_hour' => '17:30:00',
                'end_hour' => '19:30:00',
                'location' => 'Pabellon Benimaclet: sala esgrima'
            ]
        ]);
    }
}
