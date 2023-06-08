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
            'base_price' => fake()->randomFloat(5, 100, 500),
            'adult_price' => fake()->randomFloat(5, 50, 150),
            'child_price' => fake()->randomFloat(5, 50, 100),
            'taxes' => fake()->randomFloat(5, 0, 10),
            'discount' => fake()->numberBetween(0, 25),
            'characteristics' => fake()->text(),
            'hotel_id' => Hotel::factory()
        ];
    }
}