<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    public function run()
    {
        if (\App\Models\User::find(1)) {
            Event::factory()->count(5)->create(['user_id' => 1]);
            $this->command->info('Created 5 events for user with ID 1.');
        } else {
            $this->command->warn('User with ID 1 not found. Please create the user first.');
        }
    }
}
