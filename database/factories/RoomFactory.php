<?php

namespace Database\Factories;

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
            'is_available'=>fake()->boolean(),
            'base_price'=>fake()->randomFloat(2,100,500),
            'adult_price'=>fake()->randomFloat(2,100,500),
            'child_price'=>fake()->randomFloat(2,100,500),
            'taxes'=>fake()->randomFloat(2,0,10),
            'discount'=>fake()->randomFloat(2,0,100),
            'characteristics'=>fake()->text(),
            'hotel_id'=>fake()->randomNumber(1,50)
        ];
    }
}
