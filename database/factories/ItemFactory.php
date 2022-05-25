<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'market_price' => $this->faker->numberBetween(10,200),
            'image' => $this->faker->imageUrl(),
        ];
    }
    
    /**
     * Indicate that the item's market_price is between 400-500.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function suspended()
    {
        return $this->state(function (array $attributes) {
            return [
                'market_price' => $this->faker->numberBetween(400,500),
            ];
        });
    }
}
