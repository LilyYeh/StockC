<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barn>
 */
class BarnFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'iid' => $this->faker->numberBetween(1,50),
            'uid' => $this->faker->numberBetween(1,10),
            'price' => $this->faker->numberBetween(10,400),
            'type' => $this->faker->numberBetween(1,2),
            'clinch' => 0,
        ];
    }
}
