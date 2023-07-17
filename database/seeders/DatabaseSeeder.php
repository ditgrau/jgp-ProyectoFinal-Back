<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Event;
use App\Models\User;
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

        User::factory(10)->create();
        Event::factory(9)->state(new Sequence(['event_type_id' => 1], ['event_type_id' => 2], ['event_type_id' => 3]))->create();

    }
}
