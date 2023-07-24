<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('event')-> insert([
            [
                'event_type_id' => 1,
                'name' => 'Trofeo Atzar',
                'start_date' => '2023-11-11',
                'end_date' => null,
                'location' => 'Velodromo',
                'comment' => 'todxs alli a las 11:00'
            ],
            [
                'event_type_id' => 1,
                'name' => 'Trofeo Benimaclet',
                'start_date' => '2023-12-11',
                'end_date' => '2023-12-15',
                'location' => 'Pabellon Benimaclet',
                'comment' => 'desayunamos bien, que el dia será largo'
            ],
            [
                'event_type_id' => 1,
                'name' => 'Trofeo Carlet',
                'start_date' => '2023-09-11',
                'end_date' => '2023-09-12',
                'location' => 'Pabellon Carlet',
                'comment' => 'Paula saldra la primera, todxs alli para animar'
            ],
            [
                'event_type_id' => 1,
                'name' => 'Campeonato de España',
                'start_date' => '2023-10-11',
                'end_date' => '2023-10-15',
                'location' => 'Pabellon Fonteta',
                'comment' => 'Coged habitacion en el NH de al lado'
            ],
            [
                'event_type_id' => 2,
                'name' => 'GYMRO',
                'start_date' => '2023-8-11',
                'end_date' => '2023-8-15',
                'location' => 'ceulaj malaga',
                'comment' => 'Para cualquier info: info@ceulaj.com'
            ],
        ]);
    }
}
