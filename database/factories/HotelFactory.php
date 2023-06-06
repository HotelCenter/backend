<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $name = fake()->unique()->sentence();
        $slug = Str::slug($name);
        return [
            'user_id' => User::factory(),
            'name' => $name,
            'address' => fake()->address(),
            'city' => fake()->city(),
            'postcode' => fake()->postcode(),
            'country' => fake()->country(),
            'phone_number' => fake()->phoneNumber(),
            'description' => fake()->text(),
            'rating' => fake()->randomFloat(1, 0, 5),
            'image' => fake()->randomElement(['1.png', '2.png', '3.png', '4.png', '5.png', '6.png', '7.png', '8.png']),
            'slug' => $slug
        ];
    }
}