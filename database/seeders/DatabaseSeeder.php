<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Event;
use App\Models\User;
use App\Models\Result;
use App\Models\User_data;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(
            [
                RoleSeeder::class,
                Event_typeSeeder::class,
                UserSeeder::class,
                GroupSeeder::class
            ]
        );

        User::factory(10)->create(new Sequence(['confirmed' => true], ['confirmed' => false]))->create();
        User_data::factory(13)->state(new Sequence(['user_id' => 1], ['user_id' => 2], ['user_id' => 3], ['user_id' => 4], ['user_id' => 5], ['user_id' => 6], ['user_id' => 7], ['user_id' => 8], ['user_id' => 9], ['user_id' => 10], ['user_id' => 11], ['user_id' => 12], ['user_id' => 13]))->create();
        Event::factory(30)->state(new Sequence(['event_type_id' => 1, 'name' => 'Competicion'], ['event_type_id' => 2, 'name' => 'Entrenamiento extra'], ['event_type_id' => 3,'name' => 'Descanso']))->create();
        Result::factory(50)->state(new Sequence(['name' => 'Provincial'], ['name' => 'Autonomico'], ['name' => 'Nacional'], ['name' => 'Jocs'], ['name' => 'Trofeo Atzar'], ['name' => 'Trofeo Ruben Orihuela']))->create();
    }
}
