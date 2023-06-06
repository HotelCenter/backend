<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->unique()->name();
        return [
            'user_id' => fake()->numberBetween(1, 10),
            'name' => $name,
            'address' => fake()->address(),
            'city' => fake()->city(),
            'postcode' => fake()->postcode(),
            'country' => fake()->country(),
            'phone_number' => fake()->phoneNumber(),
            'description' => fake()->text(),
            'rating' => fake()->randomFloat(1, 0, 5),
            'image' => fake()->randomElement(['1.jpeg', '2.jpeg', '3.jpeg', '4.jpeg']),
            'slug' => str_replace(' ', '_', $name)
        ];
    }
}