<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'date_available' => fake()->dateTimeBetween("now", "+5 months"),
            'date_booked' => fake()->dateTimeBetween("-5 months", "now"),
            'minimum_children' => fake()->numberBetween(0, 10),
            'minimum_adults' => fake()->numberBetween(1, 10),
            'base_price' => fake()->randomFloat(2, 100, 500),
            'adult_price' => fake()->randomFloat(2, 100, 500),
            'child_price' => fake()->randomFloat(2, 100, 500),
            'taxes' => fake()->randomFloat(2, 0, 10),
            'discount' => fake()->randomFloat(2, 0, 100),
            'characteristics' => fake()->text(),
            'hotel_id' => Hotel::factory()
        ];
    }
}