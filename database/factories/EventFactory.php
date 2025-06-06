<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        return [
            'title' => '🎉 Example Event',
            'description' => 'Very cool event somewhere in Finland',
            'date' => $this->faker->dateTimeBetween('+1 days', '+1 year'),
            'lat' => $this->faker->latitude(60.15, 60.25),
            'lon' => $this->faker->longitude(24.9, 25.0),
            'location' => 'Mannerheimintie 1',
            'type' => $this->faker->randomElement(['general', 'course', 'volunteering', 'sports', 'music', 'art and culture', 'food and drink', 'networking', 'online', 'kids and family']),
            'image_url' => 'https://images.unsplash.com/photo-1472653431158-6364773b2a56?q=80&w=2740&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'user_id' => User::factory(),
            'is_public' => '1'
        ];
    }
}
